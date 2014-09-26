<?php

namespace OSS\CoreBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Event;
use OSS\CoreBundle\Entity\Fixture;
use OSS\CoreBundle\Entity\League;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Services\LeagueService;

class LeagueServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LeagueService
     */
    private $leagueService;

    public function setUp()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $this->leagueService = new LeagueService($entityManager);
    }

    public function tearDown()
    {
        $this->leagueService = null;
    }

    public function testScorer()
    {
        $league = new League();

        $team1 = new Team();
        $team1->setId(1);
        $league->addTeam($team1);

        $player1 = new Player();
        $player1->setId(1);
        $player1->setTeam($team1);

        $team2 = new Team();
        $team2->setId(2);
        $league->addTeam($team2);

        $player2 = new Player();
        $player2->setId(2);
        $player2->setTeam($team2);

        $fixture = new Fixture();
        $fixture->setTeamHome($team1);
        $fixture->setTeamAway($team2);
        $league->addFixture($fixture);

        $fixture->addEvent(Event::createGoal($fixture, $team1, $player1, 1));
        $fixture->addEvent(Event::createGoal($fixture, $team1, $player1, 2));
        $fixture->addEvent(Event::createGoal($fixture, $team2, $player2, 3));

        $scorer = $this->leagueService->getScorer(array($fixture));
        $this->assertEquals($player1, $scorer[0]->getPlayer());
        $this->assertEquals($player2, $scorer[1]->getPlayer());
        $this->assertEquals(2, $scorer[0]->getGoals());
        $this->assertEquals(1, $scorer[1]->getGoals());
    }
}
