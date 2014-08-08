<?php

namespace OSS\LeagueBundle\Controller;

use OSS\LeagueBundle\Entity\League;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return array
     *
     * @Route("/standings", name="standings")
     * @Template
     */
    public function standingsAction()
    {
        $league = $this->get('doctrine.orm.entity_manager')->getRepository('LeagueBundle:League')->findOneBy(array());

        return array(
            'standings' => $league->getStandings(),
        );
    }
}
