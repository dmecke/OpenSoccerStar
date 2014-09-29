<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
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

    public function testDefensiveSkillTransferFactor()
    {
        $this->assertTransferFactorDefensiveSkill(1, Manager::PREFERRED_SKILL_NEUTRAL);
        $this->assertTransferFactorDefensiveSkill(2, Manager::PREFERRED_SKILL_DEFENSE);
        $this->assertTransferFactorDefensiveSkill(1, Manager::PREFERRED_SKILL_OFFENSE);
    }

    public function testOffensiveSkillTransferFactor()
    {
        $this->assertTransferFactorOffensiveSkill(1, Manager::PREFERRED_SKILL_NEUTRAL);
        $this->assertTransferFactorOffensiveSkill(1, Manager::PREFERRED_SKILL_DEFENSE);
        $this->assertTransferFactorOffensiveSkill(2, Manager::PREFERRED_SKILL_OFFENSE);
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
        $this->manager->setTeam($team);
        $player1 = new Player();
        $player1->setId(1);
        $player1->setTeam($team);
        $player1->setSkillDefense(10);
        $players = array($player1);

        $this->assertNull($this->manager->selectBestFittingPlayer($players));

        $player2 = new Player();
        $player2->setId(2);
        $player2->setSkillDefense(10);
        $players[] = $player2;
        $this->assertEquals($player2, $this->manager->selectBestFittingPlayer($players));
    }

    public function testCreateTransferOffer()
    {
        $originTeam = new Team();
        $targetTeam = new Team();

        $this->manager->setTeam($targetTeam);

        $player = new Player();
        $player->setSkillDefense(10);
        $player->setSkillOffense(10);
        $player->setTeam($originTeam);

        $transferOffer = $this->manager->createTransferOffer($player);
        $this->assertEquals($originTeam, $transferOffer->getOriginTeam());
        $this->assertEquals($targetTeam, $transferOffer->getTargetTeam());
        $this->assertEquals($player, $transferOffer->getPlayer());
        $this->assertEquals(100, $transferOffer->getAmount());
    }

    private function assertTransferFactorDefensiveSkill($factor, $preferredSkill)
    {
        $this->manager->setPreferredSkill($preferredSkill);
        $this->assertEquals($factor, $this->manager->getTransferFactorDefensiveSkill());
    }

    private function assertTransferFactorOffensiveSkill($factor, $preferredSkill)
    {
        $this->manager->setPreferredSkill($preferredSkill);
        $this->assertEquals($factor, $this->manager->getTransferFactorOffensiveSkill());
    }

    private function assertTransferFactorMoneyBehaviour($factor, $moneyBehaviour)
    {
        $this->manager->setMoneyBehaviour($moneyBehaviour);
        $this->assertEquals($factor, $this->manager->getTransferFactorMoneyBehaviour());
    }
}
