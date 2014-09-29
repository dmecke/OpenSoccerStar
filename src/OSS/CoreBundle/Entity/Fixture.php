<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OSS\CoreBundle\Exception\MatchException;

/**
 * @ORM\Entity(repositoryClass="OSS\CoreBundle\Repository\FixtureRepository")
 */
class Fixture
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
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="League", inversedBy="fixtures")
     */
    private $league;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $teamHome;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $teamAway;

    /**
     * @var ArrayCollection|Event[]
     *
     * @ORM\OneToMany(targetEntity="Event", mappedBy="fixture", cascade={"all"})
     */
    private $events;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $finished = false;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $minutesPlayed = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreHome;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $scoreAway;

    /**
     * @var Lineup[]
     *
     * @ORM\OneToMany(targetEntity="Lineup", mappedBy="fixture")
     */
    private $lineups;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

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

    public function resetScoreHome()
    {
        $this->scoreHome = 0;
    }

    public function resetScoreAway()
    {
        $this->scoreAway = 0;
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
     * @return Event[]
     */
    public function getGoalEvents()
    {
        $goalEvents = array();
        foreach ($this->events as $event) {
            if ($event->isGoal()) {
                $goalEvents[] = $event;
            }
        }

        return $goalEvents;
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
            if (null !== $this->teamHome && $event->getTeam()->equals($this->teamHome)) {
                $this->scoreHome++;
            } elseif (null !== $this->teamAway && $event->getTeam()->equals($this->teamAway)) {
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

    /**
     * @param int $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * @param int $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }

    /**
     * @return int
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @return Team
     *
     * @throws MatchException
     */
    public function getWinner()
    {
        if ($this->getScoreHome() == $this->getScoreAway()) {
            throw new MatchException('this match has no winner');
        }

        return $this->scoreHome > $this->scoreAway ? $this->teamHome : $this->teamAway;
    }

    /**
     * @return bool
     */
    public function isDraw()
    {
        return $this->scoreHome == $this->scoreAway;
    }

    /**
     * @return bool
     *
     * @throws MatchException
     */
    public function isHomeTeamWinner()
    {
        return $this->getWinner()->equals($this->teamHome);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param League $league
     */
    public function setLeague(League $league)
    {
        $this->league = $league;
    }

    /**
     * @return Lineup
     *
     * @throws \Exception
     */
    public function getLineupHome()
    {
        foreach ($this->lineups as $lineup) {
            if ($lineup->getTeam()->equals($this->teamHome)) {
                return $lineup;
            }
        }

        throw new \Exception('could not find lineup for home team');
    }

    /**
     * @return Lineup
     *
     * @throws \Exception
     */
    public function getLineupAway()
    {
        foreach ($this->lineups as $lineup) {
            if ($lineup->getTeam()->equals($this->teamAway)) {
                return $lineup;
            }
        }

        throw new \Exception('could not find lineup for away team');
    }
}
