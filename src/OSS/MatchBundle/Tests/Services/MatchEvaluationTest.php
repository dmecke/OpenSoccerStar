<?php

namespace OSS\MatchBundle\Tests\Services;

use OSS\MatchBundle\Entity\Match;
use OSS\MatchBundle\Entity\Team;
use OSS\MatchBundle\Services\MatchEvaluationService;

class MatchEvaluationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        mt_srand(0); // take care to always generate the same row of random numbers
    }

    public function testHasScore()
    {
        $match = new Match();
        $team1 = new Team();
        $team1->setId(1);
        $team2 = new Team();
        $team2->setId(2);

        $match->setTeamHome($team1);
        $match->setTeamAway($team2);
        $matchEvaluation = new MatchEvaluationService();

        $matchEvaluation->evaluateCompleteMatch($match);

        $this->assertGreaterThanOrEqual(0, $match->getScoreHome());
        $this->assertGreaterThanOrEqual(0, $match->getScoreAway());
    }

    /**
     * @expectedException \OSS\MatchBundle\Exception\MatchException
     */
    public function testNoTeamsAssigned()
    {
        $match = new Match();
        $matchEvaluation = new MatchEvaluationService();

        $matchEvaluation->evaluateCompleteMatch($match);
    }

    public function testIsFinished()
    {
        $match = new Match();
        $team1 = new Team();
        $team1->setId(1);
        $team2 = new Team();
        $team2->setId(2);
        $match->setTeamHome($team1);
        $match->setTeamAway($team2);
        $matchEvaluation = new MatchEvaluationService();

        $this->assertFalse($match->isFinished());

        $matchEvaluation->evaluateMinuteOfMatch($match);
        $this->assertFalse($match->isFinished());

        $matchEvaluation->evaluateCompleteMatch($match);
        $this->assertTrue($match->isFinished());
    }

    public function testEventsGenerated()
    {
        $match = new Match();
        $team1 = new Team();
        $team1->setId(1);
        $team2 = new Team();
        $team2->setId(2);
        $match->setTeamHome($team1);
        $match->setTeamAway($team2);
        $matchEvaluation = new MatchEvaluationService();

        $matchEvaluation->evaluateCompleteMatch($match);
        $this->assertGreaterThan(0, count($match->getEvents()));
    }

    public function testHappensEvent()
    {
        $matchEvaluation = new MatchEvaluationService();

        $this->assertFalse($matchEvaluation->happensEvent());
        $this->assertTrue($matchEvaluation->happensEvent());
        $this->assertTrue($matchEvaluation->happensEvent());
    }

    public function testMinutesToPlay()
    {
        $match = new Match();
        $team1 = new Team();
        $team1->setId(1);
        $team2 = new Team();
        $team2->setId(2);
        $match->setTeamHome($team1);
        $match->setTeamAway($team2);
        $matchEvaluation = new MatchEvaluationService();

        for ($i = 0; $i <= 10; $i++) {
        }
        $this->assertGreaterThanOrEqual(90, $matchEvaluation->getMinutesToPlay());
        $this->assertLessThanOrEqual(95, $matchEvaluation->getMinutesToPlay());

        $matchEvaluation->evaluateCompleteMatch($match);
        $this->assertEquals(90, $match->getMinutesPlayed());
    }
}
