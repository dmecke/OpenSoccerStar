<?php

namespace OSS\LeagueBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\MatchBundle\Entity\Team;

/**
 * @ORM\Entity
 */
class FinalPosition
{
    /**
     * @var Team
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="OSS\MatchBundle\Entity\Team", inversedBy="finalPositions")
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $season;

    /**
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="League")
     */
    private $league;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param int $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * @return League
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @param League $league
     */
    public function setLeague(League $league)
    {
        $this->league = $league;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
