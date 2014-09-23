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
    public function calculateBuyScore(Manager $manager, Player $player)
    {
        return $this->calculateScore($manager, $player, self::TYPE_BUY);
    }

    /**
     * @param Manager $manager
     * @param Player $player
     *
     * @return int
     */
    public function calculateSellScore(Manager $manager, Player $player)
    {
        return $this->calculateScore($manager, $player, self::TYPE_SELL);
    }

    /**
     * @param Manager $manager
     * @param Player $player
     * @param string $type
     *
     * @return int
     */
    private function calculateScore(Manager $manager, Player $player, $type)
    {
        $value = $this->calculateBaseValue($player, $manager);
        $moneyPercentage = round($player->getMarketValue() / $manager->getTeam()->getMoney(), 2);
        $moneyFactor = $moneyPercentage * 10 * $manager->getTransferFactorMoneyBehaviour();

        if ($moneyFactor > 0) {
            $value = $type == self::TYPE_BUY ? $value / $moneyFactor : $value * $moneyFactor;
        } else {
            $value = 0;
        }

        return $value;
    }

    /**
     * @param Player $player
     * @param Manager $manager
     *
     * @return float
     */
    private function calculateBaseValue(Player $player, Manager $manager)
    {
        $skill = $player->getSkillDefense() * $manager->getTransferFactorDefensiveSkill() + $player->getSkillOffense() * $manager->getTransferFactorOffensiveSkill();

        return $skill / ($manager->getTransferFactorDefensiveSkill() + $manager->getTransferFactorOffensiveSkill());
    }
}
