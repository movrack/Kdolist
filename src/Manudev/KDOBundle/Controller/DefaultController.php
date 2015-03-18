<?php

namespace Manudev\KDOBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Manudev\UserBundle\Entity\User;
use JMS\DiExtraBundle\Annotation as DI;

class DefaultController extends Controller
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
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $container = $this->container;
        if( $container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
            return $this->redirect($this->generateUrl('lists'));
        }
        return array();
    }
}
