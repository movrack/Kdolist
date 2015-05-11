<?php

namespace Manudev\KDOGuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/demo1")
     * @Template()
     */
    public function demo1Action()
    {
        return array();
    }
    /**
     * @Route("/demo2")
     * @Template()
     */
    public function demo2Action()
    {
        return array();
    }
}
