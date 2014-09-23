<?php

namespace OSS\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\CoreBundle\Entity\Transfer;

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
     * @var Transfer
     *
     * @ORM\OneToMany(targetEntity="OSS\CoreBundle\Entity\Transfer", mappedBy="player")
     */
    private $transfers;

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
        if (null === $this->team || !$this->team->equals($team)) {
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
     * @return bool
     */
    public function hasTeam()
    {
        return null !== $this->team;
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

    /**
     * @return float
     */
    public function getSkillAverage()
    {
        return ($this->skillDefense + $this->skillOffense) / 2;
    }

    /**
     * @return int
     */
    public function getMarketValue()
    {
        return round(pow($this->getSkillAverage(), 6) / 10000);
    }

    /**
     * @param Player $a
     * @param Player $b
     *
     * @return bool
     */
    static public function compareAverageSkill(Player $a, Player $b)
    {
        return $a->getSkillAverage() < $b->getSkillAverage();
    }

    /**
     * @return Transfer
     */
    public function getTransfers()
    {
        return $this->transfers;
    }
}
