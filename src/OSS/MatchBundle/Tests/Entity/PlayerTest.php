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

    public function testAverage()
    {
        $player = new Player();
        $player->setSkillDefense(50);
        $player->setSkillOffense(70);
        $this->assertEquals(60, $player->getSkillAverage());
    }

    public function testCompareAverageSkill()
    {
        $player1 = new Player();
        $player1->setSkillDefense(50);
        $player1->setSkillOffense(50);

        $player2 = new Player();
        $player2->setSkillDefense(60);
        $player2->setSkillOffense(60);
        $this->assertTrue(Player::compareAverageSkill($player1, $player2));

        $player2 = new Player();
        $player2->setSkillDefense(50);
        $player2->setSkillOffense(50);
        $this->assertFalse(Player::compareAverageSkill($player1, $player2));

        $player2 = new Player();
        $player2->setSkillDefense(40);
        $player2->setSkillOffense(40);
        $this->assertFalse(Player::compareAverageSkill($player1, $player2));
    }
}
