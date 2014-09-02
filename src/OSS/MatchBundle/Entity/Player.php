<?php

namespace OSS\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Player
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
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="players")
     */
    private $team;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $skillDefense;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $skillOffense;

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function equals(Player $player)
    {
        return $this->id == $player->getId();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        if (null === $this->team) {
            $this->team = $team;
            $this->team->addPlayer($this);
        }
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @return int
     */
    public function getSkillDefense()
    {
        return $this->skillDefense;
    }

    /**
     * @param int $skillDefense
     */
    public function setSkillDefense($skillDefense)
    {
        $this->skillDefense = $skillDefense;
    }

    /**
     * @return int
     */
    public function getSkillOffense()
    {
        return $this->skillOffense;
    }

    /**
     * @param int $skillOffense
     */
    public function setSkillOffense($skillOffense)
    {
        $this->skillOffense = $skillOffense;
    }
}
