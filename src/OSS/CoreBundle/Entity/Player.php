<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Player implements PlayerSkillsAverageInterface
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
     * @var PlayerSkills
     *
     * @ORM\OneToOne(targetEntity="PlayerSkills", cascade={"all"})
     */
    private $skills;

    /**
     * @var Transfer
     *
     * @ORM\OneToMany(targetEntity="Transfer", mappedBy="player")
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
     * @return Transfer
     */
    public function getTransfers()
    {
        return $this->transfers;
    }

    /**
     * @return float
     */
    public function getAverage()
    {
        return $this->skills->getAverage();
    }

    /**
     * @return int
     */
    public function getMarketValue()
    {
        return $this->getSkills()->getMarketValue();
    }

    /**
     * @return PlayerSkills
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param PlayerSkills $skills
     */
    public function setSkills(PlayerSkills $skills)
    {
        $this->skills = $skills;
        if (null === $skills->getPlayer()) {
            $skills->setPlayer($this);
        }
    }
}
