<?php

namespace OSS\MatchBundle\Tests\Entity;

use OSS\MatchBundle\Entity\Event;
use OSS\MatchBundle\Entity\Match;
use OSS\MatchBundle\Entity\Team;

class MatchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \OSS\MatchBundle\Exception\MatchException
     */
    public function testSetTeam()
    {
        $match = new Match();
        $team = new Team();

        $match->setTeamHome($team);
        $match->setTeamAway($team);
    }

    public function testScoreMatchesEvents()
    {
        $match = new Match();
        $team1 = new Team();
        $team1->setId(1);
        $team2 = new Team();
        $team2->setId(2);
        $match->setTeamHome($team1);
        $match->setTeamAway($team2);

        $this->assertEquals(0, $this->countGoalsInEvents($match, $match->getTeamHome()));
        $this->assertEquals(0, $this->countGoalsInEvents($match, $match->getTeamAway()));
        $this->assertEquals(0, $match->getGoalsScored());

        $match->addEvent(Event::createGoal($match->getTeamHome()));
        $this->assertEquals(1, $this->countGoalsInEvents($match, $match->getTeamHome()));
        $this->assertEquals(0, $this->countGoalsInEvents($match, $match->getTeamAway()));
        $this->assertEquals(1, $match->getScoreHome());
        $this->assertEquals(0, $match->getScoreAway());
        $this->assertEquals(1, $match->getGoalsScored());
    }

    /**
     * @param Match $match
     * @param Team $team
     *
     * @return int
     */
    private function countGoalsInEvents(Match $match, Team $team)
    {
        $goalsInEvents = 0;
        foreach ($match->getEvents() as $event) {
            if ($event->isGoal() && $event->getTeam()->equals($team)) {
                $goalsInEvents++;
            }
        }

        return $goalsInEvents;
    }
}
