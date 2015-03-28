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
        $form = $this->formMailOfferGift();
        $parents = $this->em->getRepository('ManudevKDOBundle:Lists')->parents($list);

        return array(
            'entity' => $list,
            'form' => $form->createView(),
            'parents'   => $parents
        );
    }

    private function formMailOfferGift() {
        return $this->createFormBuilder()
            ->add('email', 'email', array(
                'attr' => array('placeholder' => 'Email')
            ))
            ->add('firstName', 'text', array(
                'attr' => array('placeholder' => 'Prénom')
            ))
            ->add('lastName', 'text', array(
                'attr' => array('placeholder' => 'Nom')
            ))
            ->getForm();
    }

    /**
     * @Route("/m{gift_id}", name="public_send_mail")
     * @ParamConverter("gift", class="ManudevKDOBundle:Gift", options={"id" = "gift_id"})
     * @Template("ManudevKDOBundle:PublicList:list.html.twig")
     * @Method("POST")
     */
    public function sendMailAction(Request $request, Gift $gift)
    {
        $form = $this->formMailOfferGift();
        $form->handleRequest($request);

        $email = $form->get('email')->getData();
        $firstName = $form->get('firstName')->getData();
        $lastName = $form->get('lastName')->getData();

        $parentList = $this->em->getRepository('ManudevKDOBundle:Lists')->parents($gift->getList());

        if ($form->isValid())
        {
            if(! $gift->isreserved())
            {
                $message = \Swift_Message::newInstance();
                $uri = $this->getRequest()->getUriForPath($gift->getPicture()->getWebPath());
                $picture = $message->embed(\Swift_Image::fromPath($uri));
                $template = $this->renderView('ManudevKDOBundle:PublicList:mail.reserveGift.html.twig',
                    array(
                        'firstName' => $firstName,
                        'lastName' => $lastName,
                        'gift' => $gift,
                        'picture' => $picture
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
                $this->get('session')->getFlashBag()->add(
                    'error', "Ce cadeau est réservé. Vous ne pouvez pas l'offrir."
                );
            }
        } else {
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

    popupOffer

    /**
     * @Route("/c{confirmationId}", name="public_confirm_gift")
     * @Template()
     */
    /*public function confirmGiftAction($confirmationId)
    {
        $form = $this->formMailOfferGift();
        $parents = $this->em->getRepository('ManudevKDOBundle:Lists')->parents($list);

        return array(
            'entity' => $list,
            'form' => $form->createView(),
            'parents'   => $parents
        );
    }*/

}
