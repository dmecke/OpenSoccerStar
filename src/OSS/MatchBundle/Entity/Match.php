<?php

namespace OSS\MatchBundle\Entity;

class Match
{
    /**
     * @var Team
     */
    private $teamHome;

    /**
     * @var Team
     */
    private $teamAway;

    /**
     * @var Event[]
     */
    private $events = array();

    /**
     * @var bool
     */
    private $finished = false;

    /**
     * @var int
     */
    private $minutesPlayed = 0;

    /**
     * @return int
     */
    public function getScoreHome()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getScoreAway()
    {
        return 0;
    }

    /**
     * @return bool
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * @param bool $isFinished
     */
    public function setFinished($isFinished)
    {
        $this->finished = $isFinished;
    }

    /**
     * @return bool
     */
    public function hasTeamHome()
    {
        return null !== $this->teamHome;
    }

    /**
     * @return bool
     */
    public function hasTeamAway()
    {
        return null !== $this->teamAway;
    }

    /**
     * @param Team $teamHome
     */
    public function setTeamHome(Team $teamHome)
    {
        $this->teamHome = $teamHome;
    }

    /**
     * @param Team $teamAway
     */
    public function setTeamAway(Team $teamAway)
    {
        $this->teamAway = $teamAway;
    }

    /**
     * @return Event[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param Event $event
     */
    public function addEvent(Event $event)
    {
        $this->events[] = $event;
    }

    /**
     * @return int
     */
    public function getMinutesPlayed()
    {
        return $this->minutesPlayed;
    }

    public function incrementMinutesPlayed()
    {
        $this->minutesPlayed++;
    }
}
