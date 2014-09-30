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

    /**
     * @param int $skillDefense
     * @param int $skillOffense
     * @param int $trainingValueDefense
     * @param int $trainingValueOffense
     */
    private function setUpPlayer($skillDefense, $skillOffense, $trainingValueDefense = null, $trainingValueOffense = null)
    {
        $this->player->setSkillDefense($skillDefense);
        $this->player->setSkillOffense($skillOffense);
        if (null !== $trainingValueDefense) {
            $this->player->setTrainingValueDefense($trainingValueDefense);
        }
        if (null !== $trainingValueOffense) {
            $this->player->setTrainingValueOffense($trainingValueOffense);
        }
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
        $this->setUpPlayer(50, 70);
        $this->assertEquals(60, $this->player->getSkillAverage());
    }

    public function testCompareAverageSkill()
    {
        $this->setUpPlayer(50, 50);

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
        $this->setUpPlayer(10, 10);
        $this->assertEquals(100, $this->player->getMarketValue());

        $this->setUpPlayer(50, 50);
        $this->assertEquals(1562500, $this->player->getMarketValue());

        $this->setUpPlayer(100, 100);
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

    public function testTrainingValueReduction()
    {
        $this->setUpPlayer(20, 50, 20, 20);

        $this->player->decreaseTrainingValues();
        $this->assertEquals(10, $this->player->getTrainingValueDefense());
        $this->assertEquals(-5, $this->player->getTrainingValueOffense());
    }

    public function testUpdateSkill()
    {
        $this->setUpPlayer(20, 50, 100, -100);

        $this->player->updateSkills();
        $this->assertGreaterThanOrEqual(20, $this->player->getSkillDefense());
        $this->assertLessThanOrEqual(30, $this->player->getSkillDefense());
        $this->assertEquals(0, $this->player->getTrainingValueDefense());
        $this->assertGreaterThanOrEqual(0, $this->player->getSkillChangeDefense());
        $this->assertLessThanOrEqual(10, $this->player->getSkillChangeDefense());

        $this->assertGreaterThanOrEqual(40, $this->player->getSkillOffense());
        $this->assertLessThanOrEqual(50, $this->player->getSkillOffense());
        $this->assertEquals(0, $this->player->getTrainingValueOffense());
        $this->assertGreaterThanOrEqual(-10, $this->player->getSkillChangeOffense());
        $this->assertLessThanOrEqual(0, $this->player->getSkillChangeOffense());
    }
}
