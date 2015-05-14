<?php

namespace Manudev\KDOGuiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class TemplateController
 * @package Manudev\KDOGuiBundle\Controller
 * @Route("template")
 */
class TemplateController extends Controller
{


    /**
     * @Route("/home")
     * @Template()
     */
    public function homeAction()
    {
        return array();
    }

    /**
     * @Route("/about")
     * @Template()
     */
    public function aboutAction()
    {
        return array();
    }

    /**
     * @Route("/price")
     * @Template()
     */
    public function priceAction()
    {
        return array();
    }

    /**
     * @Route("/cgu")
     * @Template()
     */
    public function cguAction()
    {
        return array();
    }

    /**
     * @Route("/features")
     * @Template()
     */
    public function featuresAction()
    {
        return array();
    }

    /**
     * @Route("/terms")
     * @Template()
     */
    public function termsAction()
    {
        return array();
    }

    /**
     * @Route("/signin")
     * @Template()
     */
    public function signinAction()
    {
        return array();
    }

    /**
     * @Route("/signup")
     * @Template()
     */
    public function signupAction()
    {
        return array();
    }

    /**
     * @Route("/list")
     * @Template()
     */
    public function listAction()
    {
        return array();
    }

    /**
     * @Route("/403")
     * @Template()
     */
    public function error403Action()
    {
        return array();
    }

    /**
     * @Route("/contact")
     * @Template()
     */
    public function contactAction()
    {
        return array();
    }

    /**
     * @Route("/faq")
     * @Template()
     */
    public function faqAction()
    {
        return array();
    }

}
