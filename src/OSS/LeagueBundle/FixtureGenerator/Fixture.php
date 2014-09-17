<?php

namespace OSS\LeagueBundle\FixtureGenerator;

class Fixture
{
    /**
     * @var int
     */
    private $teamHome;

    /**
     * @var int
     */
    private $teamAway;

    /**
     * @var int
     */
    private $week;

    /**
     * @return int
     */
    public function getTeamHome()
    {
        return $this->teamHome;
    }

    /**
     * @param int $teamHome
     */
    public function setTeamHome($teamHome)
    {
        $this->teamHome = $teamHome;
    }

    /**
     * @return int
     */
    public function getTeamAway()
    {
        return $this->teamAway;
    }

    /**
     * @param int $teamAway
     */
    public function setTeamAway($teamAway)
    {
        $this->teamAway = $teamAway;
    }

    /**
     * @return int
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param int $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }
}
