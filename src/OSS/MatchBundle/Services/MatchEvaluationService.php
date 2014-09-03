<?php

namespace OSS\MatchBundle\Services;

use OSS\MatchBundle\Entity\Event;
use OSS\MatchBundle\Entity\Fixture;
use OSS\MatchBundle\Entity\Team;
use OSS\MatchBundle\Exception\MatchException;

class MatchEvaluationService
{
    /**
     * @param Fixture $fixture
     *
     * @throws MatchException
     */
    public function evaluateCompleteMatch(Fixture $fixture)
    {
        for ($minute = 1; $minute <= $this->getMinutesToPlay(); $minute++) {
            $this->evaluateMinuteOfMatch($fixture);
        }
        $fixture->setFinished(true);
        if ($fixture->isDraw()) {
            $fixture->getTeamHome()->addPoints(1);
            $fixture->getTeamAway()->addPoints(1);
        } elseif ($fixture->isHomeTeamWinner()) {
            $fixture->getTeamHome()->addPoints(3);
        } else {
            $fixture->getTeamAway()->addPoints(3);
        }
        $fixture->getTeamHome()->addGoalsFor($fixture->getScoreHome());
        $fixture->getTeamHome()->addGoalsAgainst($fixture->getScoreAway());
        $fixture->getTeamAway()->addGoalsFor($fixture->getScoreAway());
        $fixture->getTeamAway()->addGoalsAgainst($fixture->getScoreHome());
    }

    /**
     * @param Fixture $fixture
     *
     * @throws MatchException
     */
    public function evaluateMinuteOfMatch(Fixture $fixture)
    {
        if (!$fixture->hasTeamHome()) {
            throw new MatchException('no home team');
        }
        if (!$fixture->hasTeamAway()) {
            throw new MatchException('no away team');
        }

        $fixture->incrementMinutesPlayed();
        if (null === $fixture->getScoreHome()) {
            $fixture->resetScoreHome();
        }
        if (null === $fixture->getScoreAway()) {
            $fixture->resetScoreAway();
        }
        if ($this->happensEvent()) {
            $fixture->addEvent($this->createRandomEvent($fixture));
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
        return mt_rand(1, 100) >= 95;
    }

    /**
     * @param Fixture $fixture
     *
     * @return Event
     */
    public function createRandomEvent(Fixture $fixture)
    {
        $possibleTeams = array($fixture->getTeamHome(), $fixture->getTeamAway());

        /** @var Team $attackingTeam */
        $attackingTeam = $possibleTeams[mt_rand(0, count($possibleTeams) - 1)];
        $defendingTeam = $attackingTeam->equals($fixture->getTeamHome()) ? $fixture->getTeamAway() : $fixture->getTeamHome();

        $attacker = $attackingTeam->getRandomPlayerFromLineup();
        $defender = $defendingTeam->getRandomPlayerFromLineup();

        $eventType = $attacker->getSkillOffense() * 2 > $defender->getSkillDefense() * 3 ? Event::TYPE_GOAL : Event::TYPE_CHANCE;

        $event = Event::create($fixture, $eventType, $attackingTeam, $attacker, $fixture->getMinutesPlayed());

        return $event;
    }
}
