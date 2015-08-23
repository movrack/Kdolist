<?php

namespace Manudev\KDOGuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DirectivesController
 * @package Manudev\KDOGuiBundle\Controller
 * @Route("directive")
 */
class DirectivesController extends Controller
{


    /**
     * @Route("/gift")
     * @Template()
     */
    public function giftAction()
    {
        return array();
    }

    /**
     * @Route("/progressBar")
     * @Template()
     */
    public function progressBarAction()
    {
        return array();
    }

}
