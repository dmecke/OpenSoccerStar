<?php

namespace OSS\MatchBundle\Tests\Entity;

use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

class TeamTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $team1 = new Team();
        $team2 = new Team();

        $this->assertTrue($team1->equals($team2));

        $team1->setId(1);
        $team2->setId(2);
        $this->assertFalse($team1->equals($team2));
    }

    public function testAddPlayer()
    {
        $team = new Team();

        $this->assertCount(0, $team->getPlayers());

        $player1 = new Player();
        $player1->setId(1);
        $team->addPlayer($player1);
        $this->assertCount(1, $team->getPlayers());
        $this->assertEquals($team, $player1->getTeam());
        $this->assertContains($player1, $team->getPlayers());

        $player2 = new Player();
        $player2->setId(1);
        $team->addPlayer($player2);
        $this->assertCount(2, $team->getPlayers());
        $this->assertEquals($team, $player1->getTeam());
        $this->assertEquals($team, $player2->getTeam());
        $this->assertContains($player1, $team->getPlayers());
        $this->assertContains($player2, $team->getPlayers());
    }

    public function testGetRandomPlayer()
    {
        $team = new Team();

        $player1 = new Player();
        $player1->setId(1);
        $team->addPlayer($player1);

        $player2 = new Player();
        $player2->setId(2);
        $team->addPlayer($player2);

        $this->assertContains($team->getRandomPlayer(), array($player1, $player2));
    }

    public function testResetPointsAndGoals()
    {
        $team = new Team();

        $team->setPoints(1);
        $team->setGoalsFor(1);
        $team->setGoalsAgainst(1);

        $team->resetPointsAndGoals();

        $this->assertEquals(0, $team->getPoints());
        $this->assertEquals(0, $team->getGoalsFor());
        $this->assertEquals(0, $team->getGoalsAgainst());
    }

    public function testLineup()
    {
        $team = new Team();
        $player1 = new Player();
        $player1->setId(1);
        $player1->setSkillDefense(40);
        $player1->setSkillOffense(40);
        $team->addPlayer($player1);
        for ($i = 2; $i <= 12; $i++) {
            $player = new Player();
            $player->setId($i);
            $player->setSkillDefense(50);
            $player->setSkillOffense(50);
            $team->addPlayer($player);
        }
        $player2 = new Player();
        $player2->setId(13);
        $player2->setSkillDefense(40);
        $player2->setSkillOffense(40);
        $team->addPlayer($player2);

        $this->assertCount(11, $team->getLineup());
        $this->assertNotContains($player1, $team->getLineup());
        $this->assertNotContains($player2, $team->getLineup());
    }
}
