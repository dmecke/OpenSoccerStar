<?php

namespace OSS\MatchBundle\Services;

use OSS\MatchBundle\Entity\Event;
use OSS\MatchBundle\Entity\Match;
use OSS\MatchBundle\Entity\Team;
use OSS\MatchBundle\Exception\MatchException;

class MatchEvaluation
{
    /**
     * @param Match $match
     *
     * @throws MatchException
     */
    public function evaluateCompleteMatch(Match $match)
    {
        for ($minute = 1; $minute <= $this->getMinutesToPlay(); $minute++) {
            $this->evaluateMinuteOfMatch($match);
        }
        $match->setFinished(true);
    }

    /**
     * @param Match $match
     *
     * @throws MatchException
     */
    public function evaluateMinuteOfMatch(Match $match)
    {
        if (!$match->hasTeamHome()) {
            throw new MatchException('no home team');
        }
        if (!$match->hasTeamAway()) {
            throw new MatchException('no away team');
        }

        $match->incrementMinutesPlayed();
        if ($this->happensEvent()) {
            $match->addEvent($this->createRandomEvent($match));
        }
    }

    /**
     * @return int
     */
    public function getMinutesToPlay()
    {
        return mt_rand(90, 95);
    }

    /**
     * @return bool
     */
    public function happensEvent()
    {
        return mt_rand(1, 100) >= 50;
    }

    /**
     * @param Match $match
     *
     * @return Event
     */
    public function createRandomEvent(Match $match)
    {
        $possibleEvents = array(Event::TYPE_CHANCE, Event::TYPE_GOAL);
        $possibleTeams = array($match->getTeamHome(), $match->getTeamAway());

        $event = Event::create($possibleEvents[mt_rand(0, count($possibleEvents) - 1)], $possibleTeams[mt_rand(0, count($possibleTeams) - 1)]);

        return $event;
    }
}
