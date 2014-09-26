<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;

class PlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Player
     */
    private $player;

    public function setUp()
    {
        $this->player = new Player();
    }

    public function tearDown()
    {
        $this->player = null;
    }

    public function testEquals()
    {
        $player2 = new Player();

        $this->assertTrue($this->player->equals($player2));

        $this->player->setId(1);
        $player2->setId(1);
        $this->assertTrue($this->player->equals($player2));

        $this->player->setId(1);
        $player2->setId(2);
        $this->assertFalse($this->player->equals($player2));
    }

    public function testSetTeam()
    {
        $team = new Team();

        $this->player->setTeam($team);
        $this->assertEquals($team, $this->player->getTeam());
        $this->assertContains($this->player, $team->getPlayers());
    }

    public function testAverage()
    {
        $this->setPlayerSkills(50, 70);
        $this->assertEquals(60, $this->player->getSkillAverage());
    }

    public function testCompareAverageSkill()
    {
        $this->setPlayerSkills(50, 50);

        $comparePlayer = new Player();
        $comparePlayer->setSkillDefense(60);
        $comparePlayer->setSkillOffense(60);
        $this->assertTrue(Player::compareAverageSkill($this->player, $comparePlayer));

        $comparePlayer = new Player();
        $comparePlayer->setSkillDefense(50);
        $comparePlayer->setSkillOffense(50);
        $this->assertFalse(Player::compareAverageSkill($this->player, $comparePlayer));

        $comparePlayer = new Player();
        $comparePlayer->setSkillDefense(40);
        $comparePlayer->setSkillOffense(40);
        $this->assertFalse(Player::compareAverageSkill($this->player, $comparePlayer));
    }

    public function testMarketValue()
    {
        $this->setPlayerSkills(10, 10);
        $this->assertEquals(100, $this->player->getMarketValue());

        $this->setPlayerSkills(50, 50);
        $this->assertEquals(1562500, $this->player->getMarketValue());

        $this->setPlayerSkills(100, 100);
        $this->assertEquals(100000000, $this->player->getMarketValue());
    }

    public function testGetTrainingValueDefense()
    {
        $this->assertEquals(0, $this->player->getTrainingValueDefense());
    }

    public function testSetAndGetTrainingValueDefense()
    {
        $this->player->setTrainingValueDefense(50);
        $this->assertEquals(50, $this->player->getTrainingValueDefense());
    }

    public function testGetTrainingValueOffense()
    {
        $this->assertEquals(0, $this->player->getTrainingValueOffense());
    }

    public function testSetAndGetTrainingValueOffense()
    {
        $this->player->setTrainingValueOffense(50);
        $this->assertEquals(50, $this->player->getTrainingValueOffense());
    }

    public function testAddTrainingValueDefense()
    {
        $this->player->addTrainingValueDefense(1);
        $this->assertEquals(1, $this->player->getTrainingValueDefense());
    }

    public function testAddTrainingValueOffense()
    {
        $this->player->addTrainingValueOffense(1);
        $this->assertEquals(1, $this->player->getTrainingValueOffense());
    }

    /**
     * @param int $skillDefense
     * @param int $skillOffense
     */
    private function setPlayerSkills($skillDefense, $skillOffense)
    {
        $this->player->setSkillDefense($skillDefense);
        $this->player->setSkillOffense($skillOffense);
    }
}
