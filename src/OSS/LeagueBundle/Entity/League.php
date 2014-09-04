<?php

namespace OSS\LeagueBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use OSS\MatchBundle\Entity\Team;

/**
 * @ORM\Entity
 */
class League
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection|Team[]
     *
     * @ORM\OneToMany(targetEntity="OSS\MatchBundle\Entity\Team", mappedBy="league")
     */
    private $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    /**
     * @param Team $team
     */
    public function addTeam(Team $team)
    {
        $this->teams[] = $team;
    }

    /**
     * @return Team[]
     */
    public function getStandings()
    {
        /** @var Team[] $teams */
        $teams = $this->teams->toArray();
        $points = array();
        $goalsDifference = array();
        $goalsFor = array();
        foreach ($teams as $k => $team) {
            $points[$k] = $team->getPoints();
            $goalsDifference[$k] = $team->getGoalsDifference();
            $goalsFor[$k] = $team->getGoalsFor();
        }
        array_multisort($points, SORT_DESC, $goalsDifference, SORT_DESC, $goalsFor, SORT_DESC, $teams);

        return $teams;
    }

    /**
     * @param int $position
     *
     * @return Team
     */
    public function getTeamByPosition($position)
    {
        $standings = $this->getStandings();

        return $standings[$position - 1];
    }

    /**
     * @param Team $team
     *
     * @return int|string
     *
     * @throws \Exception
     */
    public function getPositionByTeam(Team $team)
    {
        $standings = $this->getStandings();

        foreach ($standings as $index => $t) {
            if ($t->equals($team)) {
                return $index + 1;
            }
        }

        throw new \Exception('team not found in standings');
    }

    /**
     * @return ArrayCollection|Team[]
     */
    public function getTeams()
    {
        return $this->teams;
    }
}
