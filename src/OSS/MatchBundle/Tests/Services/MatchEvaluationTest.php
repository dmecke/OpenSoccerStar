<?php

namespace OSS\MatchBundle\Tests\Services;

use OSS\MatchBundle\Entity\Fixture;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;
use OSS\MatchBundle\Exception\MatchException;
use OSS\MatchBundle\Services\MatchEvaluationService;

class MatchEvaluationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        mt_srand(0); // take care to always generate the same row of random numbers
    }

    public function testHasScore()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));
        $matchEvaluation = new MatchEvaluationService();

        $matchEvaluation->evaluateCompleteMatch($fixture);

        $this->assertGreaterThanOrEqual(0, $fixture->getScoreHome());
        $this->assertGreaterThanOrEqual(0, $fixture->getScoreAway());
    }

    /**
     * @expectedException \OSS\MatchBundle\Exception\MatchException
     */
    public function testNoTeamsAssigned()
    {
        $match = new Fixture();
        $matchEvaluation = new MatchEvaluationService();

        $matchEvaluation->evaluateCompleteMatch($match);
    }

    public function testIsFinished()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));
        $matchEvaluation = new MatchEvaluationService();

        $this->assertFalse($fixture->isFinished());

        $matchEvaluation->evaluateMinuteOfMatch($fixture);
        $this->assertFalse($fixture->isFinished());

        $matchEvaluation->evaluateCompleteMatch($fixture);
        $this->assertTrue($fixture->isFinished());
    }

    public function testEventsGenerated()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));
        $matchEvaluation = new MatchEvaluationService();

        $matchEvaluation->evaluateCompleteMatch($fixture);
        $this->assertGreaterThan(0, count($fixture->getEvents()));
    }

    public function testHappensEvent()
    {
        $matchEvaluation = new MatchEvaluationService();

        for ($i = 0; $i < 32; $i++) {
            $this->assertFalse($matchEvaluation->happensEvent());
        }
        $this->assertTrue($matchEvaluation->happensEvent());
    }

    public function testMinutesToPlay()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));
        $matchEvaluation = new MatchEvaluationService();

        for ($i = 0; $i <= 10; $i++) {
            $this->assertGreaterThanOrEqual(90, $matchEvaluation->getMinutesToPlay());
            $this->assertLessThanOrEqual(95, $matchEvaluation->getMinutesToPlay());
        }

        $matchEvaluation->evaluateCompleteMatch($fixture);
        $this->assertEquals(90, $fixture->getMinutesPlayed());
    }

    public function testPointsAndGoalsForLeague()
    {
        $team1 = $this->createTeam(1);
        $team2 = $this->createTeam(2);
        $fixture = $this->createFixture($team1, $team2);
        $matchEvaluation = new MatchEvaluationService();

        $this->assertEquals(0, $team1->getPoints());
        $this->assertEquals(0, $team1->getGoalsFor());
        $this->assertEquals(0, $team1->getGoalsAgainst());
        $this->assertEquals(0, $team2->getPoints());
        $this->assertEquals(0, $team2->getGoalsFor());
        $this->assertEquals(0, $team2->getGoalsAgainst());

        $matchEvaluation->evaluateCompleteMatch($fixture);

        $this->assertEquals(1, $team1->getPoints());
        $this->assertEquals(0, $team1->getGoalsFor());
        $this->assertEquals(0, $team1->getGoalsAgainst());
        $this->assertEquals(1, $team2->getPoints());
        $this->assertEquals(0, $team2->getGoalsFor());
        $this->assertEquals(0, $team2->getGoalsAgainst());
    }

    /**
     * @param int $id
     *
     * @return Team
     */
    private function createTeam($id)
    {
        $team = new Team();
        $team->setId($id);
        $team->addPlayer(new Player());

        return $team;
    }

    /**
     * @param Team $teamHome
     * @param Team $teamAway
     *
     * @return Fixture
     *
     * @throws MatchException
     */
    private function createFixture(Team $teamHome, Team $teamAway)
    {
        $fixture = new Fixture();
        $fixture->setTeamHome($teamHome);
        $fixture->setTeamAway($teamAway);

        return $fixture;
    }
}
