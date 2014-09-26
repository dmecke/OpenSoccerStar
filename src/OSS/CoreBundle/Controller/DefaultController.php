<?php

namespace OSS\CoreBundle\Controller;

use OSS\CoreBundle\Entity\Fixture;
use OSS\CoreBundle\Entity\GameDate;
use OSS\CoreBundle\Entity\League;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class DefaultController extends Controller
{
    /**
     * @return array
     *
     * @Route("/transfers", name="transfers")
     * @Template
     */
    public function transfersAction()
    {
        $gameDate = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:GameDate')->findOneBy(array());

        return array(
            'transferOffers' => $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:TransferOffer')->findAll(),
            'transfers' => $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:Transfer')->findBy(array('season' => $gameDate->getSeason())),
        );
    }
    
    /**
     * @return array
     *
     * @Route("/standings", name="standings")
     * @Template
     */
    public function standingsAction()
    {
        $league = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:League')->findOneBy(array());

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
        $fixtures = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:Fixture')->findBy(array('season' => $gameDate->getSeason()));

        return array(
            'fixtures' => $fixtures,
        );
    }

    /**
     * @return array
     *
     * @Route("/scorer", name="scorer")
     * @Template
     */
    public function scorerAction()
    {
        /** @var League $league */
        $league = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:League')->findOneBy(array());

        /** @var GameDate $gameDate */
        $gameDate = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:GameDate')->findOneBy(array());

        $fixtures = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:Fixture')->findByLeagueAndSeasonWithEvents($league, $gameDate->getSeason());

        return array(
            'scorerList' => $this->get('oss.core.service.league')->getScorer($fixtures),
        );
    }

    /**
     * @param Fixture $fixture
     *
     * @return array
     *
     * @Route("/fixture/{id}", name="fixture")
     * @Template
     */
    public function fixtureAction(Fixture $fixture)
    {
        return array(
            'fixture' => $fixture,
        );
    }
}
