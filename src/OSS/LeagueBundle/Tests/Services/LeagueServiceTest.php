<?php

namespace OSS\LeagueBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
use OSS\LeagueBundle\Entity\League;
use OSS\LeagueBundle\Services\LeagueService;
use OSS\MatchBundle\Entity\Event;
use OSS\MatchBundle\Entity\Fixture;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

class LeagueServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testScorer()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $leagueService = new LeagueService($entityManager);
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

        $scorer = $leagueService->getScorer(array($fixture));
        $this->assertEquals($player1, $scorer[0]->getPlayer());
        $this->assertEquals($player2, $scorer[1]->getPlayer());
        $this->assertEquals(2, $scorer[0]->getGoals());
        $this->assertEquals(1, $scorer[1]->getGoals());
    }
}
