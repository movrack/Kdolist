<?php
namespace Manudev\KDOApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

use Manudev\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\DiExtraBundle\Annotation as DI;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class UsersController
 * @package Manudev\KDOApiBundle\Controller
 * @property \Doctrine\Bundle\DoctrineBundle\Registry $em
 */
class ListsController extends FOSRestController
{
    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $em;

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get a list",
     *  requirements={
     *    {
     *      "name"="id",
     *      "dataType"="integer",
     *      "description"="List ID"
     *    }
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      200="No content",
     *      404={
     *          "Returned when something goes wrong"
     *      }
     *  },
     *  output="Manudev\KDOBundle\Entity\Lists"
     * )
     * @Rest\View()
     */
    public function getListAction($id)
    {
        $lists = $this->em->getRepository('ManudevKDOBundle:Lists')->findById($id);
        $view = View::create()
            ->setStatusCode(200)
            ->setData($lists);

        return $this->get('fos_rest.view_handler')->handle($view);
    }


}