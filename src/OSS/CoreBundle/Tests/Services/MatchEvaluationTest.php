<?php

namespace OSS\CoreBundle\Tests\Services;

use OSS\CoreBundle\Entity\Fixture;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Exception\MatchException;
use OSS\CoreBundle\Services\MatchEvaluationService;

class MatchEvaluationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MatchEvaluationService
     */
    private $matchEvaluationService;

    public function setUp()
    {
        mt_srand(0); // take care to always generate the same row of random numbers
        $this->matchEvaluationService = new MatchEvaluationService();
    }

    public function tearDown()
    {
        $this->matchEvaluationService = null;
    }

    public function testHasScore()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));

        $this->matchEvaluationService->evaluateCompleteMatch($fixture);

        $this->assertGreaterThanOrEqual(0, $fixture->getScoreHome());
        $this->assertGreaterThanOrEqual(0, $fixture->getScoreAway());
    }

    /**
     * @expectedException \OSS\CoreBundle\Exception\MatchException
     */
    public function testNoTeamsAssigned()
    {
        $this->matchEvaluationService->evaluateCompleteMatch(new Fixture());
    }

    public function testIsFinished()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));

        $this->assertFalse($fixture->isFinished());

        $this->matchEvaluationService->evaluateMinuteOfMatch($fixture);
        $this->assertFalse($fixture->isFinished());

        $this->matchEvaluationService->evaluateCompleteMatch($fixture);
        $this->assertTrue($fixture->isFinished());
    }

    public function testEventsGenerated()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));

        $this->matchEvaluationService->evaluateCompleteMatch($fixture);
        $this->assertGreaterThan(0, count($fixture->getEvents()));
    }

    public function testHappensEvent()
    {
        for ($i = 0; $i < 32; $i++) {
            $this->assertFalse($this->matchEvaluationService->happensEvent());
        }
        $this->assertTrue($this->matchEvaluationService->happensEvent());
    }

    public function testMinutesToPlay()
    {
        $fixture = $this->createFixture($this->createTeam(1), $this->createTeam(2));

        for ($i = 0; $i <= 10; $i++) {
            $this->assertGreaterThanOrEqual(90, $this->matchEvaluationService->getMinutesToPlay());
            $this->assertLessThanOrEqual(95, $this->matchEvaluationService->getMinutesToPlay());
        }

        $this->matchEvaluationService->evaluateCompleteMatch($fixture);
        $this->assertEquals(90, $fixture->getMinutesPlayed());
    }

    public function testPointsAndGoalsForLeague()
    {
        $team1 = $this->createTeam(1);
        $team2 = $this->createTeam(2);
        $fixture = $this->createFixture($team1, $team2);

        $this->assertEquals(0, $team1->getPoints());
        $this->assertEquals(0, $team1->getGoalsFor());
        $this->assertEquals(0, $team1->getGoalsAgainst());
        $this->assertEquals(0, $team2->getPoints());
        $this->assertEquals(0, $team2->getGoalsFor());
        $this->assertEquals(0, $team2->getGoalsAgainst());

        $this->matchEvaluationService->evaluateCompleteMatch($fixture);

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
        $player = new Player();
        $skills = new PlayerSkills();
        $player->setSkills($skills);
        $team->addPlayer($player);

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
