<?php

namespace OSS\MatchBundle\Tests\Entity;

use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

class PlayerTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $player1 = new Player();
        $player2 = new Player();

        $this->assertTrue($player1->equals($player2));

        $player1->setId(1);
        $player2->setId(1);
        $this->assertTrue($player1->equals($player2));

        $player1->setId(1);
        $player2->setId(2);
        $this->assertFalse($player1->equals($player2));
    }

    public function testSetTeam()
    {
        $team = new Team();
        $player = new Player();

        $player->setTeam($team);
        $this->assertEquals($team, $player->getTeam());
        $this->assertContains($player, $team->getPlayers());
    }
}
