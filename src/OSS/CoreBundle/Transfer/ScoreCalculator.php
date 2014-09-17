<?php

namespace OSS\CoreBundle\Transfer;

use OSS\CoreBundle\Entity\Manager;
use OSS\MatchBundle\Entity\Player;

class ScoreCalculator
{
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    /**
     * @param Manager $manager
     * @param Player $player
     *
     * @return int
     */
    public function calculateBuy(Manager $manager, Player $player)
    {
        return $this->calculate($manager, $player, self::TYPE_BUY);
    }

    /**
     * @param Manager $manager
     * @param Player $player
     *
     * @return int
     */
    public function calculateSell(Manager $manager, Player $player)
    {
        return $this->calculate($manager, $player, self::TYPE_SELL);
    }

    /**
     * @param Manager $manager
     * @param Player $player
     * @param string $type
     *
     * @return int
     */
    private function calculate(Manager $manager, Player $player, $type)
    {
        $defensiveFactor = $manager->getPreferredSkill() == Manager::PREFERRED_SKILL_DEFENSE ? 2 : 1;
        $offensiveFactor = $manager->getPreferredSkill() == Manager::PREFERRED_SKILL_OFFENSE ? 2 : 1;

        $skill = $player->getSkillDefense() * $defensiveFactor + $player->getSkillOffense() * $offensiveFactor;

        $value = $skill / ($defensiveFactor + $offensiveFactor);

        $moneyPercentage = round($player->getMarketValue() / $manager->getTeam()->getMoney(), 2);
        $moneyFactor = $moneyPercentage * 10;
        if ($manager->getMoneyBehaviour() == Manager::MONEY_BEHAVIOUR_DEFENSIVE) {
            $moneyFactor *= 2;
        } elseif ($manager->getMoneyBehaviour() == Manager::MONEY_BEHAVIOUR_OFFENSIVE) {
            $moneyFactor /= 2;
        }

        if ($moneyFactor > 0) {
            $value = $type == self::TYPE_BUY ? $value / $moneyFactor : $value * $moneyFactor;
        } else {
            $value = 0;
        }

        return $value;
    }
}
