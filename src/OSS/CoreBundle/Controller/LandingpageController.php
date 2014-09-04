<?php

namespace OSS\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class LandingpageController extends Controller
{
    /**
     * @return array
     *
     * @Route("", name="landingpage")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @return array
     *
     * @Route("/privacy", name="privacy")
     * @Template
     */
    public function privacyAction()
    {
        return array();
    }
}
