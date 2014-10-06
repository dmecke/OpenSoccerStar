<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;
use OSS\CoreBundle\Entity\Team;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    public function setUp()
    {
        $this->manager = new Manager();
    }

    public function tearDown()
    {
        $this->manager = null;
    }

    public function testGetTeam()
    {
        $this->assertNull($this->manager->getTeam());
    }

    public function testSetAndGetTeam()
    {
        $team = new Team();
        $this->manager->setTeam($team);
        $this->assertEquals($team, $this->manager->getTeam());
        $this->assertEquals($this->manager, $team->getManager());
    }

    public function testTransferFactors()
    {
        $allFactors = $this->manager->getTransferFactorTackling() + $this->manager->getTransferFactorPassing() + $this->manager->getTransferFactorShooting() + $this->manager->getTransferFactorHeading() + $this->manager->getTransferFactorSpeed() + $this->manager->getTransferFactorCrossing() + $this->manager->getTransferFactorTechnics() + $this->manager->getTransferFactorIntelligence() + $this->manager->getTransferFactorSafety() + $this->manager->getTransferFactorDribbling();
        $this->assertEquals(100, $allFactors);
    }

    public function testDefensiveMoneyTransferFactor()
    {
        $this->assertTransferFactorMoneyBehaviour(1, Manager::MONEY_BEHAVIOUR_NEUTRAL);
        $this->assertTransferFactorMoneyBehaviour(2, Manager::MONEY_BEHAVIOUR_DEFENSIVE);
        $this->assertTransferFactorMoneyBehaviour(0.5, Manager::MONEY_BEHAVIOUR_OFFENSIVE);
    }

    public function testAcceptTransferOffer()
    {
        $this->manager->setAcceptTransferScoreOffset(100);
        $this->assertTrue($this->manager->acceptTransferOffer(150));
        $this->assertTrue($this->manager->acceptTransferOffer(100));
        $this->assertFalse($this->manager->acceptTransferOffer(99));
        $this->assertFalse($this->manager->acceptTransferOffer(50));
    }

    public function testDenyTransferOffer()
    {
        $this->manager->setDenyTransferScoreOffset(50);
        $this->assertTrue($this->manager->denyTransferOffer(25));
        $this->assertTrue($this->manager->denyTransferOffer(50));
        $this->assertFalse($this->manager->denyTransferOffer(51));
        $this->assertFalse($this->manager->denyTransferOffer(100));
    }

    public function testSelectBestFittingPlayer()
    {
        $team = new Team();
        $team->setId(1);
        $team->setMoney(10);
        $player1 = new Player();
        $this->manager->setTeam($team);
        $skills1 = new PlayerSkills();
        $skills1->setAll(10);
        $player1->setId(1);
        $player1->setTeam($team);
        $player1->setSkills($skills1);
        $players = array($player1);

        $this->assertNull($this->manager->selectBestFittingPlayer($players));

        $skills2 = new PlayerSkills();
        $skills2->setAll(20);
        $player2 = new Player();
        $player2->setId(2);
        $player2->setSkills($skills2);
        $players[] = $player2;
        $this->assertEquals($player2, $this->manager->selectBestFittingPlayer($players));
    }

    public function testCreateTransferOffer()
    {
        $originTeam = new Team();
        $targetTeam = new Team();

        $this->manager->setTeam($targetTeam);

        $skills = new PlayerSkills();
        $skills->setAll(10);

        $player = new Player();
        $player->setSkills($skills);
        $player->setTeam($originTeam);

        $transferOffer = $this->manager->createTransferOffer($player);
        $this->assertEquals($originTeam, $transferOffer->getOriginTeam());
        $this->assertEquals($targetTeam, $transferOffer->getTargetTeam());
        $this->assertEquals($player, $transferOffer->getPlayer());
        $this->assertEquals(100, $transferOffer->getAmount());
    }

    private function assertTransferFactorMoneyBehaviour($factor, $moneyBehaviour)
    {
        $this->manager->setMoneyBehaviour($moneyBehaviour);
        $this->assertEquals($factor, $this->manager->getTransferFactorMoneyBehaviour());
    }
}
