<?php

namespace OSS\MatchBundle\Services;

use OSS\MatchBundle\Entity\Event;
use OSS\MatchBundle\Entity\Match;
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
            $match->addEvent(new Event());
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
}
