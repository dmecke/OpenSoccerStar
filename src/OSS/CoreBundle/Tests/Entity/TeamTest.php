<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;
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
        $skills1 = new PlayerSkills();
        $skills1->setAll(40);
        $player1 = new Player();
        $player1->setId(1);
        $player1->setSkills($skills1);
        $this->team->addPlayer($player1);
        for ($i = 2; $i <= 12; $i++) {
            $skills = new PlayerSkills();
            $skills->setAll(50);
            $player = new Player();
            $player->setId($i);
            $player->setSkills($skills);
            $this->team->addPlayer($player);
        }
        $skills2 = new PlayerSkills();
        $skills2->setAll(40);
        $player2 = new Player();
        $player2->setId(13);
        $player2->setSkills($skills2);
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
        $player1 = new Player();
        $skills1 = new PlayerSkills();
        $player1->setSkills($skills1);
        $this->team->setTrainer(new Trainer());
        $this->team->addPlayer($player1);
        $skills = new PlayerSkills();
        $skills->setAllTrainingValues(10);
        $player = new Player();
        $player->setSkills($skills);
        $this->team->addPlayer($player);

        $this->team->train();
        $players = $this->team->getPlayers();
        $this->assertEquals(1, $players[0]->getSkills()->getTrainingValueTackling());
        $this->assertEquals(11, $players[1]->getSkills()->getTrainingValueTackling());
    }

    public function testHandleTrainingWithoutTrainer()
    {
        $player = new Player();
        $skills = new PlayerSkills();
        $player->setSkills($skills);
        $this->team->addPlayer($player);

        $this->team->train();
        $players = $this->team->getPlayers();
        $this->assertEquals(0, $players[0]->getSkills()->getTrainingValueTackling());
        $this->assertEquals(0, $players[0]->getSkills()->getTrainingValueTackling());
    }

    public function testSendMoney()
    {
        $this->team->setMoney(1000);
        $targetTeam = new Team();
        $this->team->sendMoney($targetTeam, 500);
        $this->assertEquals(500, $this->team->getMoney());
        $this->assertEquals(500, $targetTeam->getMoney());
    }
}
