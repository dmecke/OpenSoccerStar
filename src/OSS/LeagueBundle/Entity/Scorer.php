<?php

namespace OSS\LeagueBundle\Entity;

use OSS\MatchBundle\Entity\Player;

class Scorer
{
    /**
     * @var Scorer[]
     */
    static $scorer = array();

    /**
     * @var Player
     */
    private $player;

    /**
     * @var int
     */
    private $goals;

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return int
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @param int $goals
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;
    }

    public function incrementGoals()
    {
        $this->goals++;
    }
}
