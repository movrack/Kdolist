<?php

namespace KDO\Bundle\KDOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;
use KDO\Bundle\KDOBundle\Entity\User;
use KDO\Bundle\KDOBundle\Entity\Lists;
use KDO\Bundle\KDOBundle\Entity\Gift;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PublicListController
 * @package KDO\Bundle\KDOBundle\Controller
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
     * @ParamConverter("list", class="KDOKDOBundle:Lists", options={"id" = "list_id"})
     * @Template()
     */
    public function listAction(Lists $list)
    {
        $form = $this->formMailOfferGift();

        return array(
            'entity' => $list,
            'form' => $form->createView()
        );
    }

    private function formMailOfferGift() {
        return $this->createFormBuilder()
            ->add('email', 'email', array(
                'attr' => array('placeholder' => 'monNom@maBoiteMail.com')
            ))
            ->getForm();
    }

    /**
     * @Route("/m{gift_id}", name="public_send_mail")
     * @ParamConverter("gift", class="KDOKDOBundle:Gift", options={"id" = "gift_id"})
     * @Template("KDOKDOBundle:PublicList:list.html.twig")
     * @Method("POST")
     */
    public function sendMailAction(Request $request, Gift $gift)
    {
        $form = $this->formMailOfferGift();
        $form->handleRequest($request);
        $email = $form->get('email')->getData();

        if ($form->isValid()) {
            // fait quelque chose comme sauvegarder la tâche dans la bdd
echo "ok";
            $this->get('session')->getFlashBag()->add(
                'notice', "Un email vous a été envoyé à l'adresse suivante : $email<br />
                            Une fois confirmé, votre cadeau disparaitra de la liste."
            );
            $message = \Swift_Message::newInstance()
                ->setSubject('Kdolist test')
                ->setFrom('send@example.com')
                ->setTo($email)
                ->setBody("Mail send for gift ")
            ;
            $this->get('mailer')->send($message);
            echo "mail send";

        } else {
echo "ko";
            $this->get('session')->getFlashBag()->add(
                'error', "Une erreur est survenue. Vueillez vérifier votre adresse email:
                 $email"
            );
        }
        return array(
            'entity' => $gift->getList(),
            'form' => $form->createView()
        );
    }

}
