<?php

namespace OSS\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\MatchBundle\Exception\MatchException;

/**
 * @ORM\Entity
 * @ORM\Table(name="`Match`")
 */
class Match
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $season;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $week;

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
     * @var int
     */
    private $scoreHome = 0;

    /**
     * @var int
     */
    private $scoreAway = 0;

    /**
     * @return int
     */
    public function getScoreHome()
    {
        return $this->scoreHome;
    }

    /**
     * @return int
     */
    public function getScoreAway()
    {
        return $this->scoreAway;
    }

    /**
     * @return int
     */
    public function getGoalsScored()
    {
        return $this->getScoreHome() + $this->getScoreAway();
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
     *
     * @throws MatchException
     */
    public function setTeamHome(Team $teamHome)
    {
        if ($this->hasTeamAway() && $this->getTeamAway()->equals($teamHome)) {
            throw new MatchException('home team must not be the same as away team');
        }

        $this->teamHome = $teamHome;
    }

    /**
     * @param Team $teamAway
     *
     * @throws MatchException
     */
    public function setTeamAway(Team $teamAway)
    {
        if ($this->hasTeamHome() && $this->getTeamHome()->equals($teamAway)) {
            throw new MatchException('away team must not be the same as home team');
        }

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
     *
     * @throws MatchException
     */
    public function addEvent(Event $event)
    {
        $this->events[] = $event;
        if ($event->isGoal()) {
            if ($event->getTeam()->equals($this->teamHome)) {
                $this->scoreHome++;
            } elseif ($event->getTeam()->equals($this->teamAway)) {
                $this->scoreAway++;
            } else {
                throw new MatchException('team with id ' . $event->getTeam()->getId() . ' is not part of this match');
            }
        }
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

    /**
     * @return Team
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * @return Team
     */
    public function getTeamAway()
    {
        return $this->teamAway;
    }
}
