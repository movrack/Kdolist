<?php

namespace Manudev\UserBundle\Controller;

use Manudev\UserBundle\Entity\User;
use Manudev\UserBundle\Entity\BankAccount;
use Manudev\UserBundle\Form\BankAccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class ProfileController
 * @package Manudev\UserBundle\Controller
 */
class ProfileController extends BaseController
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
    function __construct($securityContext)
    {
        $this->user = $securityContext->getToken()->getUser();
    }

    /**
     *
     * @Route("/", name="profile")
     * @Method("GET")
     */
    public function showAction()
    {
        $form = $this->createFormBankAccount(new BankAccount());
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $this->user,
            'bankAccountForm' => $form->createView()
        ));
    }


    /**
     *
     * @Route("/postBankAccount/{user_id}", name="profile_createBankAccount")
     * @Method("POST")
     * @ParamConverter("user", class="ManudevUserBundle:User", options={"id" = "user_id"})
     * @Template("FOSUserBundle:Profile:show.html.twig")
     */
    public function createBankAccountAction(Request $request, User $user)
    {
        $entity = new BankAccount();
        $form = $this->createFormBankAccount($entity);
        $form->handleRequest($request);

        $isCurrentUser = $user->getId() == $this->user->getId();

        if ($form->isValid() && $isCurrentUser) {
            $user->addBankaccount($entity);
            $this->em->persist($entity);
            $this->em->persist($user);
            $this->em->flush();

            $this->get('session')->getFlashBag()->add('success', 'entity.create.success');
            return $this->redirect($this->generateUrl('profile'));

        } elseif (!$isCurrentUser) {
            $this->get('session')->getFlashBag()
                ->add('success', 'Vous ne pouvez pas créer un compte en banque pour un autre utilisateur.');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'entity.create.error');
        }

        return array(
            'user' => $this->user,
            'bankAccountForm' => $form->createView()
        );
    }

    /**
     * Creates a form to create a BankAccount entity.
     *
     * @param BankAccount $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFormBankAccount(BankAccount $entity)
    {
        $form = $this->createForm(
            new BankAccountType(),
            $entity,
            array(
                'action' =>
                    $this->generateUrl(
                        'profile_createBankAccount',
                        array("user_id" => $this->user->getId()
                    )
                ),
               'method' => 'POST',
            )
        );

        return $form;
    }

}