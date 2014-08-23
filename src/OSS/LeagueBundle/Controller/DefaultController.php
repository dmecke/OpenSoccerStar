<?php

namespace OSS\LeagueBundle\Controller;

use OSS\CoreBundle\Entity\GameDate;
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

    /**
     * @return array
     *
     * @Route("/fixtures", name="fixtures")
     * @Template
     */
    public function fixturesAction()
    {
        /** @var GameDate $gameDate */
        $gameDate = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:GameDate')->findOneBy(array());
        $fixtures = $this->get('doctrine.orm.entity_manager')->getRepository('MatchBundle:Fixture')->findBy(array('season' => $gameDate->getSeason()));

        return array(
            'fixtures' => $fixtures,
        );
    }
}
