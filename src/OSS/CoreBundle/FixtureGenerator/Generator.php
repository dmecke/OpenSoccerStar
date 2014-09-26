<?php

namespace OSS\CoreBundle\FixtureGenerator;

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

        for ($i = 1; $i <= (($this->numberOfTeams / 2) - 1); $i++) {
            $fixtures = array_merge($fixtures, $this->createFixturesForMatchIndex($currentWeek, $i));
        }

        return $fixtures;
    }

    /**
     * @param int $week
     * @param int $index
     *
     * @return Fixture[]
     */
    private function createFixturesForMatchIndex($week, $index)
    {
        $fixtures = array();
        $this->currentAwayTeam = $this->findCurrentAwayTeam($this->numberOfTeams, $week, $index);
        $this->currentHomeTeam = $this->findCurrentHomeTeam($this->numberOfTeams, $week, $index);

        if ($index % 2 == 0) {
            $this->toggleHomeAndAwayTeam();
        }

        if ($this->shallFixtureBeGenerated()) {
            $fixtures[] = $this->createFixture($this->currentHomeTeam, $this->currentAwayTeam, $week);
        }

        return $fixtures;
    }

    /**
     * @param int $numberOfTeams
     * @param int $week
     * @param int $index
     *
     * @return int
     */
    private function findCurrentHomeTeam($numberOfTeams, $week, $index)
    {
        return $this->wrapTeam(($week + $index) % ($numberOfTeams - 1));
    }

    /**
     * @param int $numberOfTeams
     * @param int $week
     * @param int $index
     *
     * @return int
     */
    private function findCurrentAwayTeam($numberOfTeams, $week, $index)
    {
        if ($week - $index < 0) {
            $team = $numberOfTeams - 1 + $week - $index;
        } else {
            $team = $this->wrapTeam(($week - $index) % ($numberOfTeams - 1));
        }

        return $team;
    }

    /**
     * @param int $team
     *
     * @return int
     */
    public function wrapTeam($team)
    {
        if ($team == 0) {
            $team = $this->numberOfTeams - 1;
        }

        return $team;
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
