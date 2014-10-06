<?php

namespace OSS\CoreBundle\Transfer;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;

class ScoreCalculator
{
    const TYPE_BUY = 'buy';
    const TYPE_SELL = 'sell';

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param Player $player
     *
     * @return int
     */
    public function calculateBuyScore(Player $player)
    {
        return $this->calculateScore($player, self::TYPE_BUY);
    }

    /**
     * @param Player $player
     *
     * @return int
     */
    public function calculateSellScore(Player $player)
    {
        if ($this->manager->getTeam()->getPlayers()->count() <= 11) {
            return -1;
        }

        return $this->calculateScore($player, self::TYPE_SELL);
    }

    /**
     * @param Player $player
     * @param string $type
     *
     * @return int
     */
    private function calculateScore(Player $player, $type)
    {
        $value = $this->calculateBaseValue($player);
        $moneyFactor = $this->getMoneyPercentage($player->getMarketValue(), $this->manager->getTeam()->getMoney()) * 10 * $this->manager->getTransferFactorMoneyBehaviour();

        if ($moneyFactor > 0) {
            $value = $type == self::TYPE_BUY ? $value / $moneyFactor : $value * $moneyFactor * 2;
        } else {
            $value = -1;
        }

        return $value;
    }

    /**
     * @param int $marketValue
     * @param int $money
     *
     * @return float
     */
    public function getMoneyPercentage($marketValue, $money)
    {
        if (empty($money)) {
            return 0;
        }

        return round($marketValue / $money, 2);
    }

    /**
     * @param Player $player
     *
     * @return float
     */
    private function calculateBaseValue(Player $player)
    {
        return $player->getSkills()->getTackling() * $this->manager->getTransferFactorTackling() / 100
               + $player->getSkills()->getPassing() * $this->manager->getTransferFactorPassing() / 100
               + $player->getSkills()->getShooting() * $this->manager->getTransferFactorShooting() / 100
               + $player->getSkills()->getHeading() * $this->manager->getTransferFactorHeading() / 100
               + $player->getSkills()->getSpeed() * $this->manager->getTransferFactorSpeed() / 100
               + $player->getSkills()->getCrossing() * $this->manager->getTransferFactorCrossing() / 100
               + $player->getSkills()->getTechnics() * $this->manager->getTransferFactorTechnics() / 100
               + $player->getSkills()->getIntelligence() * $this->manager->getTransferFactorIntelligence() / 100
               + $player->getSkills()->getSafety() * $this->manager->getTransferFactorSafety() / 100
               + $player->getSkills()->getDribbling() * $this->manager->getTransferFactorDribbling() / 100;
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }
}
