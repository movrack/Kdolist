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
use Symfony\Component\HttpFoundation\Response;

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
        /*$container = $this->container;
        if( $container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->redirect($this->generateUrl('lists'));
        }*/
        return array(
            'entity' => $list
        );
    }

}
