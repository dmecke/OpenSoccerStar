<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Transfer\ScoreCalculator;

class ScoreCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ScoreCalculator
     */
    private $scoreCalculator;

    /**
     * @var Player
     */
    private $player;

    public function setUp()
    {
        $manager = new Manager();
        $manager->setTeam(new Team());
        for ($i = 1; $i <= 20; $i++) {
            $manager->getTeam()->addPlayer(new Player());
        }
        $this->scoreCalculator = new ScoreCalculator($manager);
        $this->player = new Player();
        $this->player->setSkills(new PlayerSkills());
    }

    public function tearDown()
    {
        $this->scoreCalculator = null;
        $this->player = null;
    }

    public function testCalculateSkill1()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(15625000);
        $this->player->getSkills()->setAll(50);
        $this->assertEquals(50, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkill2()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(15625000);
        $this->player->getSkills()->setAll(50);
        $this->player->getSkills()->setTackling(100);
        $this->player->getSkills()->setDribbling(100);
        $this->assertEquals(20, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkill3()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(15625000);
        $this->scoreCalculator->getManager()->setTransferFactorTackling(20);
        $this->scoreCalculator->getManager()->setTransferFactorCrossing(0);
        $this->player->getSkills()->setAll(50);
        $this->player->getSkills()->setTackling(100);
        $this->player->getSkills()->setCrossing(0);
        $this->assertEquals(60, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkill4()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(1000000000);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(100, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkillMoney1()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(500000000);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(50, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkillMoney2()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(500000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_DEFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(25, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkillMoney3()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(2000000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_DEFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(100, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkillMoney4()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(500000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_OFFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(100, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkillMoney5()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(2000000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_OFFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(400, $this->scoreCalculator->calculateBuyScore($this->player));
    }

    public function testCalculateSkillMoneySell1()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(500000000);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(400, $this->scoreCalculator->calculateSellScore($this->player));
    }

    public function testCalculateSkillMoneySell2()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(500000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_DEFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(800, $this->scoreCalculator->calculateSellScore($this->player));
    }

    public function testCalculateSkillMoneySell3()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(2000000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_DEFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(200, $this->scoreCalculator->calculateSellScore($this->player));
    }

    public function testCalculateSkillMoneySell4()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(500000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_OFFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(200, $this->scoreCalculator->calculateSellScore($this->player));
    }

    public function testCalculateSkillMoneySell5()
    {
        $this->scoreCalculator->getManager()->getTeam()->setMoney(2000000000);
        $this->scoreCalculator->getManager()->setMoneyBehaviour(Manager::MONEY_BEHAVIOUR_OFFENSIVE);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(50, $this->scoreCalculator->calculateSellScore($this->player));
    }

    public function testCalculateSellWithLessThan11Players()
    {
        $team = new Team();
        $team->setMoney(1000000);
        $this->scoreCalculator->getManager()->setTeam($team);
        $this->player->getSkills()->setAll(100);
        $this->assertEquals(-1, $this->scoreCalculator->calculateSellScore($this->player));
    }

    public function testGetMoneyPercentage()
    {
        $this->assertEquals(0.1, $this->scoreCalculator->getMoneyPercentage(10, 100));
        $this->assertEquals(1, $this->scoreCalculator->getMoneyPercentage(100, 100));
        $this->assertEquals(0, $this->scoreCalculator->getMoneyPercentage(100, 0));
    }
}
