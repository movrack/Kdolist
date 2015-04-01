<?php

namespace Manudev\KDOBundle\Controller;

use Manudev\KDOBundle\Entity\GiftReservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use Manudev\UserBundle\Entity\User;
use Manudev\KDOBundle\Entity\Lists;
use Manudev\KDOBundle\Entity\Gift;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PublicListController
 * @package Manudev\KDOBundle\Controller
 * @Route("/p")
 */
class PublicListController extends Controller
{

    /**
     * @var User
     */
    private $user;

    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /**
     * @DI\InjectParams({
     *     "securityContext" = @DI\Inject("security.context")
     * })
     */
    function __construct($securityContext) {
        $this->user = $securityContext->getToken()->getUser();
    }

    /**
     * @Route("/l{list_id}", name="public_list_noSlug")
     * @Route("/l{list_id}/{slug}", name="public_list")
     * @ParamConverter("list", class="ManudevKDOBundle:Lists", options={"id" = "list_id"})
     * @Template()
     */
    public function listAction(Lists $list)
    {
        $parents = $this->em->getRepository('ManudevKDOBundle:Lists')->parents($list);
        // Clean reservations
        $this->em->getRepository('ManudevKDOBundle:GiftReservation')->cleanReservations();
        return array(
            'entity' => $list,
            'parents'   => $parents
        );
    }

    private function formMailOfferGift(Gift $gift) {
        $form = $this->createFormBuilder();
        $form->setAction($this->generateUrl('public_give_gift', array('gift_id' => $gift->getId())));
        $form->setMethod('POST');
        $form->add('email', 'email', array(
                'attr' => array('placeholder' => 'Email')
            ))
            ->add('firstName', 'text', array(
                'attr' => array('placeholder' => 'Prénom')
            ))
            ->add('lastName', 'text', array(
                'attr' => array('placeholder' => 'Nom')
            ));

        if($gift->getAccepteMultipleParts() && $gift->getPrice() != null) {
            $form->add('numberOfParts', 'integer', array(
                'data' => 1,
                'attr' => array(
                    'min' => 0,
                    'max' => $gift->getNumberOfParts() - $gift->getGivedParts(),
                ),
            ));
        }
        else if ($gift->getPrice() != null) {
            $form->add('price', 'number', array(
                'data' => $gift->getPrice(),
                'disabled' => true,
                'attr' => array('readonly' => true)
            ));
        }
        return $form->getForm();
    }

    /**
     * @Route("/r{code}-{gift_id}-{reservation_id}/{email}")
     * @ParamConverter("gift", class="ManudevKDOBundle:Gift", options={"id" = "gift_id"})
     * @ParamConverter("reservation", class="ManudevKDOBundle:GiftReservation", options={"id" = "reservation_id"})
     * @Template()
     */
    public function validateReseravationAction(Request $request, $code, Gift $gift, GiftReservation $reservation, $email) {

        $success = $reservation->getEmail() == $email
            && $reservation->getUniqCode() == $code
            && $reservation->getGift() == $gift
            && $code == GiftReservation::hashUniqCode($reservation, $gift, $email);

            $isOldReservation = $reservation->getStatus() != GiftReservation::STATUS_RESERVED;
            if ($success && !$isOldReservation) {
                $reservation->setStatus(GiftReservation::STATUS_CONFIRMED);
                $gift->setGivedParts($gift->getGivedParts() + $reservation->getGivedParts());

                $this->em->persist($gift);
                $this->em->persist($reservation);
                $this->em->flush();
            }

        return array(
            'success' => $success,
            'isOldReservation' => $isOldReservation,
            'gift' => $gift,
            'reservation' => $reservation,
            'email' => $email
        );
    }

    /**
     * @Route("/c{code}-{gift_id}-{reservation_id}/{email}")
     * @ParamConverter("gift", class="ManudevKDOBundle:Gift", options={"id" = "gift_id"})
     * @ParamConverter("reservation", class="ManudevKDOBundle:GiftReservation", options={"id" = "reservation_id"})
     * @Template()
     */
    public function cancelReseravationAction(Request $request, $code, Gift $gift, GiftReservation $reservation, $email) {
        $success = $reservation->getEmail() == $email
            && $reservation->getUniqCode() == $code
            && $reservation->getGift() == $gift
            && $code == GiftReservation::hashUniqCode($reservation, $gift, $email);

        $isReserved = $reservation->getStatus() == GiftReservation::STATUS_RESERVED;
        $isConfirmed = $reservation->getStatus() == GiftReservation::STATUS_CONFIRMED;
        $isGived = $reservation->getStatus() == GiftReservation::STATUS_GIVED;
        if ($success && $isReserved) {
            $this->em->remove($reservation);
            $this->em->flush();
        }

        return array(
            'isReserved' => $isReserved,
            'isConfirmed' => $isConfirmed,
            'isGived' => $isGived,
            'success' => $success,
            'gift' => $gift,
            'reservation' => $reservation,
            'email' => $email
        );
    }

    /**
     * @Route("/m{gift_id}", name="public_give_gift")
     * @ParamConverter("gift", class="ManudevKDOBundle:Gift", options={"id" = "gift_id"})
     * @Template("ManudevKDOBundle:PublicList:list.html.twig")
     * @Method("POST")
     */
    public function giveGiftAction(Request $request, Gift $gift)
    {
        $form = $this->formMailOfferGift($gift);
        $form->handleRequest($request);

        $email = $form->get('email')->getData();
        $firstName = $form->get('firstName')->getData();
        $lastName = $form->get('lastName')->getData();
        $numberOfParts = 1;
        $price = $gift->getPrice();

        if($gift->getAccepteMultipleParts() && $gift->getPrice() != null) {
            $numberOfParts = $form->get('numberOfParts')->getData();

            $price = $numberOfParts * $gift->partValue();
        } else if ($gift->getPrice() != null) {
            $price = $gift->getPrice();
        }

        $parentList = $this->em->getRepository('ManudevKDOBundle:Lists')->parents($gift->getList());

        if ($form->isValid())
        {
            if(!$gift->isReserved())
            {
                $reservation = new GiftReservation();
                $reservation->setEmail($email);
                $reservation->setFirstName($firstName);
                $reservation->setLastName($lastName);
                $reservation->setGift($gift);
                $reservation->setGivedParts($numberOfParts);

                $this->em->persist($reservation);
                $this->em->flush();
                $code = GiftReservation::hashUniqCode($reservation, $gift, $email);
                $reservation->setUniqCode($code);
                $this->em->persist($reservation);
                $this->em->flush();

                $url = $this->generateUrl('manudev_kdo_publiclist_validatereseravation', array(
                    'code' => $code,
                    'gift_id' => $gift->getId(),
                    'reservation_id' => $reservation->getId(),
                    'email' => $email
                ), true);

                $urlCancel = $this->generateUrl('manudev_kdo_publiclist_cancelreseravation', array(
                    'code' => $code,
                    'gift_id' => $gift->getId(),
                    'reservation_id' => $reservation->getId(),
                    'email' => $email
                ), true);


                $message = \Swift_Message::newInstance();
                $uri = $this->getRequest()->getUriForPath($gift->getPicture()->getWebPath(), true);
                $picture = $message->embed(\Swift_Image::fromPath($uri));
                $template = $this->renderView('ManudevKDOBundle:PublicList:mail.reserveGift.html.twig',
                    array(
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'gift' => $gift,
                        'picture' => $picture,
                        'price' => $price,
                        'numberOfParts' => $numberOfParts,
                        'url' => $url,
                        'urlCancel' => $urlCancel
                    )
                );
                $message->setSubject('Réservation de Cadeau')
                    ->setFrom('gift@kdolist.manudev.be')
                    ->setTo($email)
                    ->setBody($template, 'text/html');

                $this->get('mailer')->send($message);


                $this->get('session')->getFlashBag()->add(
                    'success', "Un email de confirmation vous a été envoyé sur: $email .
                     Sans confirmation, le cadeau sera à nouveau disponible pour d'autres personnes
                     dans 2 jours."
                );
                return $this->redirect($this->generateUrl('public_list', array('list_id' => $gift->getList()->getId(), 'slug' => $gift->getList()->getSlug())));
            } else {
                // Already reserved
                $this->get('session')->getFlashBag()->add(
                    'error', "Ce cadeau est réservé. Vous ne pouvez pas l'offrir."
                );
            }
        } else {
            // Not valid
            $this->get('session')->getFlashBag()->add(
                'error', "Une erreur est survenue. Vueillez vérifier votre adresse email:
                 $email"
            );
        }

        return array(
            'entity' => $gift->getList(),
            'form' => $form->createView(),
            'parents' => $parentList
        );
    }

    /**
     *
     * @Route("/p{id}", name="popup_offer_gift")
     * @Template()
     */
    public function popupOfferAction(Gift $gift) {

        $form = $this->formMailOfferGift($gift);
        return array(
            'gift' => $gift,
            'form' => $form->createView()
        );
    }


}
