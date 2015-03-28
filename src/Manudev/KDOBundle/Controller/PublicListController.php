<?php

namespace Manudev\KDOBundle\Controller;

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
                'data' => 0,
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
                $message = \Swift_Message::newInstance();
                $uri = $this->getRequest()->getUriForPath($gift->getPicture()->getWebPath());
                $picture = $message->embed(\Swift_Image::fromPath($uri));
                $template = $this->renderView('ManudevKDOBundle:PublicList:mail.reserveGift.html.twig',
                    array(
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'gift' => $gift,
                        'picture' => $picture,
                        'price' => $price,
                        'numberOfParts' => $numberOfParts
                    )
                );
                $message->setSubject('Réservation de Cadeau')
                    ->setFrom('gift@kdolist.manudev.be')
                    ->setTo($email)
                    ->setBody($template, 'text/html');

                $this->get('mailer')->send($message);


                $this->get('session')->getFlashBag()->add(
                    'success', "Un email de confirmation vous a été envoyé sur: $email .
                     Sans confirmation, le cadeau sera à nouveau dispoblie pour d'autres personnes
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
