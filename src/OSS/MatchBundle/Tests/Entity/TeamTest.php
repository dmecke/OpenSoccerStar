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

        $player = new Player();
        $team->addPlayer($player);
        $this->assertCount(1, $team->getPlayers());
        $this->assertEquals($team, $player->getTeam());
        $this->assertContains($player, $team->getPlayers());
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
}
