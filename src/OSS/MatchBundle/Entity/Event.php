<?php

namespace OSS\MatchBundle\Entity;

class Event
{
    const TYPE_CHANCE = 'chance';
    const TYPE_GOAL = 'goal';

    /**
     * @var string
     */
    private $type;

    /**
     * @var Team
     */
    private $team;

    private function __construct()
    {
    }

    /**
     * @param string $type
     * @param Team $team
     *
     * @return Event
     */
    static public function create($type, Team $team)
    {
        $event = new Event();
        $event->setType($type);
        $event->setTeam($team);

        return $event;
    }

    /**
     * @param Team $team
     *
     * @return Event
     */
    static public function createGoal(Team $team)
    {
        return self::create(self::TYPE_GOAL, $team);
    }

    /**
     * @param Team $team
     *
     * @return Event
     */
    static public function createChance(Team $team)
    {
        return self::create(self::TYPE_CHANCE, $team);
    }

    private function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isGoal()
    {
        return self::TYPE_GOAL == $this->type;
    }

    /**
     * @return bool
     */
    public function isChance()
    {
        return self::TYPE_CHANCE == $this->type;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}
