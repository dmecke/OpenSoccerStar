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
}
