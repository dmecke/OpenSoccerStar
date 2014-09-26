<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Trainer
{
    const PREFERRED_TRAINING_DEFENSIVE = 1;
    const PREFERRED_TRAINING_NEUTRAL = 2;
    const PREFERRED_TRAINING_OFFENSIVE = 3;

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $preferredTraining = self::PREFERRED_TRAINING_NEUTRAL;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $skill;

    /**
     * @var Team
     *
     * @ORM\OneToOne(targetEntity="Team", inversedBy="trainer")
     */
    private $team;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return int
     */
    public function getPreferredTraining()
    {
        return $this->preferredTraining;
    }

    /**
     * @param int $preferredTraining
     */
    public function setPreferredTraining($preferredTraining)
    {
        $this->preferredTraining = $preferredTraining;
    }

    /**
     * @return int
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param int $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
        if (null === $team->getTrainer()) {
            $team->setTrainer($this);
        }
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}
