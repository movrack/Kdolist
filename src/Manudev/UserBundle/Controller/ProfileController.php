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
        $form = $this->createBankAccountForm(new BankAccount());
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $this->user,
            'toto' => 'tutu',
            'bankAccountForm' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/", name="bankAccountCreate")
     * @Method("GET")
     */
    public function bankaccountCreateAction()
    {
        $form = $this->createBankAccountForm(new BankAccount());
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $this->user,
            'toto' => 'tutu',
            'bankAccountForm' => $form->createView()
        ));
    }

    /**
     * Creates a form to create a BankAccount entity.
     *
     * @param BankAccount $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBankAccountForm(BankAccount $entity)
    {
        $form = $this->createForm(new BankAccountType(), $entity, array(
            'action' => $this->generateUrl('bankAccountCreate'),
            'method' => 'POST',
        ));

        return $form;
    }

}