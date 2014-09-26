<?php

namespace OSS\CoreBundle\Manager;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Scorer;

class ScorerManager
{
    /**
     * @var Scorer[]
     */
    private $scorer = array();

    /**
     * @param Player $player
     *
     * @return Scorer
     */
    public function addAndGetByPlayer(Player $player)
    {
        foreach ($this->scorer as $scorer) {
            if ($scorer->getPlayer()->equals($player)) {
                return $scorer;
            }
        }

        $scorer = new Scorer();
        $scorer->setPlayer($player);
        $this->scorer[] = $scorer;

        return $scorer;
    }

    public function getAllOrdered()
    {
        $goals = array();
        foreach ($this->scorer as $k => $scorer) {
            $goals[$k] = $scorer->getGoals();
        }

        array_multisort($goals, SORT_DESC, $this->scorer);

        return $this->scorer;
    }
}
