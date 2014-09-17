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
        $this->assertCalculateBuyEquals(50, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 15625000, 50, 50);
        $this->assertCalculateBuyEquals(65, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 75418890, 80, 50);
        $this->assertCalculateBuyEquals(70, Manager::PREFERRED_SKILL_DEFENSE, Manager::MONEY_BEHAVIOUR_NEUTRAL, 75418890, 80, 50);
        $this->assertCalculateBuyEquals(60, Manager::PREFERRED_SKILL_OFFENSE, Manager::MONEY_BEHAVIOUR_NEUTRAL, 75418890, 80, 50);
        $this->assertCalculateBuyEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 1000000000, 100, 100);
    }

    public function testCalculateMoneyBuy()
    {
        $this->assertCalculateBuyEquals(50, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 500000000, 100, 100);
        $this->assertCalculateBuyEquals(25, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 500000000, 100, 100);
        $this->assertCalculateBuyEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 2000000000, 100, 100);
        $this->assertCalculateBuyEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 500000000, 100, 100);
        $this->assertCalculateBuyEquals(400, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 2000000000, 100, 100);
    }

    public function testCalculateMoneySell()
    {
        $this->assertCalculateSellEquals(200, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_NEUTRAL, 500000000, 100, 100);
        $this->assertCalculateSellEquals(400, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 500000000, 100, 100);
        $this->assertCalculateSellEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_DEFENSIVE, 2000000000, 100, 100);
        $this->assertCalculateSellEquals(100, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 500000000, 100, 100);
        $this->assertCalculateSellEquals(25, Manager::PREFERRED_SKILL_NEUTRAL, Manager::MONEY_BEHAVIOUR_OFFENSIVE, 2000000000, 100, 100);
    }

    private function assertCalculateBuyEquals($value, $preferredSkill, $moneyBehaviour, $money, $playerDefense, $playerOffense)
    {
        $calculator = new ScoreCalculator();

        $manager = $this->createManager($preferredSkill, $moneyBehaviour, $money);
        $player = $this->createPlayer($playerDefense, $playerOffense);
        $this->assertEquals($value, $calculator->calculateBuy($manager, $player));
    }

    private function assertCalculateSellEquals($value, $preferredSkill, $moneyBehaviour, $money, $playerDefense, $playerOffense)
    {
        $calculator = new ScoreCalculator();

        $manager = $this->createManager($preferredSkill, $moneyBehaviour, $money);
        $player = $this->createPlayer($playerDefense, $playerOffense);
        $this->assertEquals($value, $calculator->calculateSell($manager, $player));
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
