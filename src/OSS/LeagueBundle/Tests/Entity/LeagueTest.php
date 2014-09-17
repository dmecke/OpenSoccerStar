<?php

namespace OSS\LeagueBundle\Tests\Entity;

use OSS\LeagueBundle\Entity\League;
use OSS\MatchBundle\Entity\Team;

class LeagueTest extends \PHPUnit_Framework_TestCase
{
    public function testAddTeams()
    {
        $league = new League();
        $team = new Team();

        $league->addTeam($team);
        $this->assertContains($team, $league->getStandings());
    }

    public function testBasicStandings()
    {
        $league = new League();

        $team1 = new Team();
        $team1->setId(1);
        $team1->setPoints(1);
        $league->addTeam($team1);

        $team2 = new Team();
        $team2->setId(2);
        $team2->setPoints(3);
        $league->addTeam($team2);

        $standings = $league->getStandings();

        $teamOnPosition1 = array_shift($standings);
        $this->assertEquals(2, $teamOnPosition1->getId());

        $teamOnPosition2 = array_shift($standings);
        $this->assertEquals(1, $teamOnPosition2->getId());

        $this->assertTrue($league->getTeamByPosition(1)->equals($team2));
        $this->assertTrue($league->getTeamByPosition(2)->equals($team1));
    }

    public function testStandingsWithGoalsDifference()
    {
        $league = new League();

        $team1 = new Team();
        $team1->setId(1);
        $team1->setPoints(1);
        $team1->setGoalsFor(3);
        $league->addTeam($team1);

        $team2 = new Team();
        $team2->setId(2);
        $team2->setPoints(1);
        $team2->setGoalsFor(5);
        $league->addTeam($team2);

        $this->assertTrue($league->getTeamByPosition(1)->equals($team2));
        $this->assertTrue($league->getTeamByPosition(2)->equals($team1));
    }

    public function testStandingsWithGoalsFor()
    {
        $league = new League();

        $team1 = new Team();
        $team1->setId(1);
        $team1->setPoints(1);
        $team1->setGoalsFor(5);
        $team1->setGoalsAgainst(3);
        $league->addTeam($team1);

        $team2 = new Team();
        $team2->setId(2);
        $team2->setPoints(1);
        $team2->setGoalsFor(6);
        $team2->setGoalsAgainst(4);
        $league->addTeam($team2);

        $this->assertTrue($league->getTeamByPosition(1)->equals($team2));
        $this->assertTrue($league->getTeamByPosition(2)->equals($team1));
    }

    public function testGetPositionByTeam()
    {
        $league = new League();

        $team1 = new Team();
        $team1->setId(1);
        $team1->setPoints(1);
        $league->addTeam($team1);

        $team2 = new Team();
        $team2->setId(2);
        $team2->setPoints(3);
        $league->addTeam($team2);

        $this->assertEquals(1, $league->getPositionByTeam($team2));
        $this->assertEquals(2, $league->getPositionByTeam($team1));
    }
}
