<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Transfer\ScoreCalculator;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

class ScoreCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateSkill()
    {
        //@todo use assertCalculateBuyEquals
        $calculator = new ScoreCalculator();

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 15625000);
        $player = $this->createPlayer(50, 50);
        $this->assertEquals(50, $calculator->calculateBuy($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 75418890);
        $player = $this->createPlayer(80, 50);
        $this->assertEquals(65, $calculator->calculateBuy($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_DEFENSE, Manager::MONEY_BEHAVIOUR_NEUTRAL, 75418890);
        $player = $this->createPlayer(80, 50);
        $this->assertEquals(70, $calculator->calculateBuy($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_OFFENSE, Manager::MONEY_BEHAVIOUR_NEUTRAL, 75418890);
        $player = $this->createPlayer(80, 50);
        $this->assertEquals(60, $calculator->calculateBuy($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 1000000000);
        $player = $this->createPlayer(100, 100);
        $this->assertEquals(100, $calculator->calculateBuy($manager, $player));
    }

    public function testCalculateMoneyBuy()
    {
        $this->assertCalculateBuyEquals(50, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 500000000, 100, 100);
        $this->assertCalculateBuyEquals(25, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 500000000, 100, 100);
        $this->assertCalculateBuyEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 2000000000, 100, 100);
        $this->assertCalculateBuyEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 500000000, 100, 100);
        $this->assertCalculateBuyEquals(400, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 2000000000, 100, 100);
    }

    private function assertCalculateBuyEquals($value, $preferredSkill, $moneyBehaviour, $money, $playerDefense, $playerOffense)
    {
        $calculator = new ScoreCalculator();

        $manager = $this->createManager($preferredSkill, $moneyBehaviour, $money);
        $player = $this->createPlayer($playerDefense, $playerOffense);
        $this->assertEquals($value, $calculator->calculateBuy($manager, $player));
    }

    public function testCalculateMoneySell()
    {
        //@todo use assertCalculateSellEquals
        $calculator = new ScoreCalculator();

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 500000000);
        $player = $this->createPlayer(100, 100);
        $this->assertEquals(200, $calculator->calculateSell($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 500000000);
        $player = $this->createPlayer(100, 100);
        $this->assertEquals(400, $calculator->calculateSell($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 2000000000);
        $player = $this->createPlayer(100, 100);
        $this->assertEquals(100, $calculator->calculateSell($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 500000000);
        $player = $this->createPlayer(100, 100);
        $this->assertEquals(100, $calculator->calculateSell($manager, $player));

        $manager = $this->createManager(Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 2000000000);
        $player = $this->createPlayer(100, 100);
        $this->assertEquals(25, $calculator->calculateSell($manager, $player));
    }

    /**
     * @param int $money
     *
     * @return Team
     */
    private function createTeam($money)
    {
        $team = new Team();
        $team->setMoney($money);

        return $team;
    }

    /**
     * @param int $preferredSkill
     * @param int $moneyBehaviour
     * @param int $money
     *
     * @return Manager
     */
    private function createManager($preferredSkill, $moneyBehaviour, $money)
    {
        $manager = new Manager();
        $manager->setPreferredSkill($preferredSkill);
        $manager->setMoneyBehaviour($moneyBehaviour);
        $manager->setTeam($this->createTeam($money));

        return $manager;
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
