<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;

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
        $team1 = new Team();
        $team1->setId(1);
        $team2 = new Team();
        $team2->setId(2);
        $player = new Player();

        $player->setTeam($team1);
        $this->assertEquals($team1, $player->getTeam());
        $this->assertContains($player, $team1->getPlayers());

        $player->setTeam($team2);
        $this->assertEquals($team2, $player->getTeam());
        $this->assertContains($player, $team2->getPlayers());
    }

    public function testAverage()
    {
        $player = $this->createPlayer(50, 70);
        $this->assertEquals(60, $player->getSkillAverage());
    }

    public function testCompareAverageSkill()
    {
        $player1 = $this->createPlayer(50, 50);
        $player2 = $this->createPlayer(60, 60);
        $this->assertTrue(Player::compareAverageSkill($player1, $player2));

        $player2 = $this->createPlayer(50, 50);
        $this->assertFalse(Player::compareAverageSkill($player1, $player2));

        $player2 = $this->createPlayer(40, 40);
        $this->assertFalse(Player::compareAverageSkill($player1, $player2));
    }

    public function testMarketValue()
    {
        $this->assertEquals(100, $this->createPlayer(10, 10)->getMarketValue());
        $this->assertEquals(1562500, $this->createPlayer(50, 50)->getMarketValue());
        $this->assertEquals(100000000, $this->createPlayer(100, 100)->getMarketValue());
    }

    /**
     * @param int $skillDefense
     * @param int $skillOffense
     *
     * @return Player
     */
    private function createPlayer($skillDefense, $skillOffense)
    {
        $player = new Player();
        $player->setSkillDefense($skillDefense);
        $player->setSkillOffense($skillOffense);

        return $player;
    }
}
