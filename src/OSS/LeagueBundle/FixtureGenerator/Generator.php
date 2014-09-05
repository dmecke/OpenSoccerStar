<?php

namespace OSS\LeagueBundle\FixtureGenerator;

class Generator
{
    /**
     * @var bool
     */
    private $hasGhostTeam = false;

    /**
     * @var int
     */
    private $numberOfTeams;

    /**
     * @var int
     */
    private $currentHomeTeam;

    /**
     * @var int
     */
    private $currentAwayTeam;

    /**
     * @param int $numberOfTeams
     */
    public function __construct($numberOfTeams)
    {
        $this->hasGhostTeam = $numberOfTeams % 2 > 0;
        if ($numberOfTeams % 2 > 0) {
            $numberOfTeams++;
        }
        $this->numberOfTeams = $numberOfTeams;
    }

    /**
     * @return Fixture[]
     *
     * @throws \Exception
     */
    public function createFixtures()
    {
        $fixtures = $this->createInitialFixtures();
        $returnFixtures = $this->createReturnFixtures($fixtures);

        return array_merge($fixtures, $returnFixtures);
    }

    /**
     * @param int $home
     * @param int $away
     * @param int $week
     *
     * @return Fixture
     */
    private function createFixture($home, $away, $week)
    {
        $fixture = new Fixture();
        $fixture->setTeamHome($home);
        $fixture->setTeamAway($away);
        $fixture->setWeek($week);

        return $fixture;
    }

    /**
     * @return Fixture[]
     */
    private function createInitialFixtures()
    {
        $fixtures = array();
        for ($currentWeek = 1; $currentWeek <= $this->numberOfTeams - 1; $currentWeek++) {
            $fixtures = array_merge($fixtures, $this->createFixturesForWeek($currentWeek));
        }

        return $fixtures;
    }

    /**
     * @param int $currentWeek
     *
     * @return Fixture[]
     */
    private function createFixturesForWeek($currentWeek)
    {
        $fixtures = array();
        $this->currentHomeTeam = $this->numberOfTeams;
        $this->currentAwayTeam = $currentWeek;

        if (($currentWeek % 2) != 0) {
            $this->toggleHomeAndAwayTeam();
        }

        if ($this->shallFixtureBeGenerated()) {
            $fixtures[] = $this->createFixture($this->currentHomeTeam, $this->currentAwayTeam, $currentWeek);
        }

        for ($k = 1; $k <= (($this->numberOfTeams / 2) - 1); $k++) {

            if ($currentWeek - $k < 0) {
                $this->currentAwayTeam = $this->numberOfTeams - 1 + $currentWeek - $k;
            } else {
                $this->currentAwayTeam = ($currentWeek - $k) % ($this->numberOfTeams - 1);
                $this->currentAwayTeam = ($this->currentAwayTeam == 0) ? ($this->numberOfTeams - 1) : $this->currentAwayTeam; // 0 -> n-1
            }

            $this->currentHomeTeam = ($currentWeek + $k) % ($this->numberOfTeams - 1);
            $this->currentHomeTeam = ($this->currentHomeTeam == 0) ? ($this->numberOfTeams - 1) : $this->currentHomeTeam;    // 0 -> n-1

            if ($k % 2 == 0) {
                $this->toggleHomeAndAwayTeam();
            }

            if ($this->shallFixtureBeGenerated()) {
                $fixtures[] = $this->createFixture($this->currentHomeTeam, $this->currentAwayTeam, $currentWeek);
            }
        }

        return $fixtures;
    }

    public function toggleHomeAndAwayTeam()
    {
        $temp = $this->currentAwayTeam;
        $this->currentAwayTeam = $this->currentHomeTeam;
        $this->currentHomeTeam = $temp;
    }

    /**
     * @return bool
     */
    private function isLastTeamCurrent()
    {
        return $this->numberOfTeams == $this->currentHomeTeam || $this->numberOfTeams == $this->currentAwayTeam;
    }

    /**
     * @return bool
     */
    private function shallFixtureBeGenerated()
    {
        return !$this->hasGhostTeam || !$this->isLastTeamCurrent();
    }

    /**
     * @param Fixture[] $homeFixtures
     *
     * @return Fixture[]
     */
    private function createReturnFixtures($homeFixtures)
    {
        $fixtures = array();
        foreach ($homeFixtures as $homeFixture) {
            if (!$this->hasGhostTeam || ($this->numberOfTeams != $homeFixture->getTeamAway() && $this->numberOfTeams != $homeFixture->getTeamHome())) {
                $fixtures[] = $this->createFixture($homeFixture->getTeamAway(), $homeFixture->getTeamHome(), $homeFixture->getWeek() + $this->numberOfTeams - 1);
            }
        }

        return $fixtures;
    }

    /**
     * @return int
     */
    public function getCurrentHomeTeam()
    {
        return $this->currentHomeTeam;
    }

    /**
     * @param int $currentHomeTeam
     */
    public function setCurrentHomeTeam($currentHomeTeam)
    {
        $this->currentHomeTeam = $currentHomeTeam;
    }

    /**
     * @return int
     */
    public function getCurrentAwayTeam()
    {
        return $this->currentAwayTeam;
    }

    /**
     * @param int $currentAwayTeam
     */
    public function setCurrentAwayTeam($currentAwayTeam)
    {
        $this->currentAwayTeam = $currentAwayTeam;
    }
}
