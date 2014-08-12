<?php

namespace OSS\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\LeagueBundle\Entity\League;

/**
 * @ORM\Entity
 */
class Team
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="OSS\LeagueBundle\Entity\League", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsFor = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsAgainst = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Team $team
     *
     * @return bool
     */
    public function equals(Team $team)
    {
        return $this->getId() == $team->getId();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $goalsFor
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;
    }

    /**
     * @return int
     */
    public function getGoalsDifference()
    {
        return $this->goalsFor - $this->goalsAgainst;
    }

    /**
     * @param int $goalsAgainst
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;
    }

    /**
     * @return int
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * @return int
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param League $league
     */
    public function setLeague(League $league)
    {
        $this->league = $league;
    }
}
