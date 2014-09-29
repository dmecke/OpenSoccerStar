<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Entity\Trainer;

class TeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Team
     */
    private $team;

    public function setUp()
    {
        $this->team = new Team();
    }

    public function tearDown()
    {
        $this->team = null;
    }

    public function testEquals()
    {
        $compareTeam = new Team();

        $this->assertTrue($this->team->equals($compareTeam));

        $this->team->setId(1);
        $compareTeam->setId(2);
        $this->assertFalse($this->team->equals($compareTeam));
    }

    public function testAddPlayer()
    {
        $this->assertCount(0, $this->team->getPlayers());

        $player1 = new Player();
        $player1->setId(1);
        $this->team->addPlayer($player1);
        $this->assertCount(1, $this->team->getPlayers());
        $this->assertEquals($this->team, $player1->getTeam());
        $this->assertContains($player1, $this->team->getPlayers());

        $player2 = new Player();
        $player2->setId(1);
        $this->team->addPlayer($player2);
        $this->assertCount(2, $this->team->getPlayers());
        $this->assertEquals($this->team, $player1->getTeam());
        $this->assertEquals($this->team, $player2->getTeam());
        $this->assertContains($player1, $this->team->getPlayers());
        $this->assertContains($player2, $this->team->getPlayers());
    }

    public function testGetRandomPlayer()
    {
        $player1 = new Player();
        $player1->setId(1);
        $this->team->addPlayer($player1);

        $player2 = new Player();
        $player2->setId(2);
        $this->team->addPlayer($player2);

        $this->assertContains($this->team->getRandomPlayer(), array($player1, $player2));
    }

    public function testResetPointsAndGoals()
    {
        $this->team->setPoints(1);
        $this->team->setGoalsFor(1);
        $this->team->setGoalsAgainst(1);

        $this->team->resetPointsAndGoals();

        $this->assertEquals(0, $this->team->getPoints());
        $this->assertEquals(0, $this->team->getGoalsFor());
        $this->assertEquals(0, $this->team->getGoalsAgainst());
    }

    public function testLineup()
    {
        $player1 = new Player();
        $player1->setId(1);
        $player1->setSkillDefense(40);
        $player1->setSkillOffense(40);
        $this->team->addPlayer($player1);
        for ($i = 2; $i <= 12; $i++) {
            $player = new Player();
            $player->setId($i);
            $player->setSkillDefense(50);
            $player->setSkillOffense(50);
            $this->team->addPlayer($player);
        }
        $player2 = new Player();
        $player2->setId(13);
        $player2->setSkillDefense(40);
        $player2->setSkillOffense(40);
        $this->team->addPlayer($player2);

        $this->assertCount(11, $this->team->getLineup());
        $this->assertNotContains($player1, $this->team->getLineup());
        $this->assertNotContains($player2, $this->team->getLineup());
    }

    public function testGetTrainer()
    {
        $this->assertNull($this->team->getTrainer());
    }

    public function testSetAndGetTrainer()
    {
        $trainer = new Trainer();
        $this->team->setTrainer($trainer);
        $this->assertEquals($trainer, $this->team->getTrainer());
        $this->assertEquals($this->team, $trainer->getTeam());
    }

    public function testHasTrainer()
    {
        $this->assertFalse($this->team->hasTrainer());
        $this->team->setTrainer(new Trainer());
        $this->assertTrue($this->team->hasTrainer());
    }

    public function testGetManager()
    {
        $this->assertNull($this->team->getManager());
    }

    public function testSetAndGetManager()
    {
        $manager = new Manager();
        $this->team->setManager($manager);
        $this->assertEquals($manager, $this->team->getManager());
        $this->assertEquals($this->team, $manager->getTeam());
    }

    public function testHasManager()
    {
        $this->assertFalse($this->team->hasManager());
        $this->team->setManager(new Manager());
        $this->assertTrue($this->team->hasManager());
    }

    public function testHandleTraining()
    {
        $this->team->setTrainer(new Trainer());
        $this->team->addPlayer(new Player());
        $player = new Player();
        $player->setTrainingValueDefense(10);
        $player->setTrainingValueOffense(10);
        $this->team->addPlayer($player);

        $this->team->train();
        $players = $this->team->getPlayers();
        $this->assertEquals(1, $players[0]->getTrainingValueDefense());
        $this->assertEquals(1, $players[0]->getTrainingValueOffense());
        $this->assertEquals(11, $players[1]->getTrainingValueDefense());
        $this->assertEquals(11, $players[1]->getTrainingValueOffense());
    }

    public function testHandleTrainingWithoutTrainer()
    {
        $this->team->addPlayer(new Player());

        $this->team->train();
        $players = $this->team->getPlayers();
        $this->assertEquals(0, $players[0]->getTrainingValueDefense());
        $this->assertEquals(0, $players[0]->getTrainingValueOffense());
    }
}
