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
    private $skill = 1;

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
     * @return float
     */
    public function getTrainingFactorDefensive()
    {
        return $this->getTrainingFactor(0.75, 0.25);
    }

    /**
     * @return float
     */
    public function getTrainingFactorOffensive()
    {
        return $this->getTrainingFactor(0.25, 0.75);
    }

    /**
     * @param float $defensiveFactor
     * @param float $offensiveFactor
     *
     * @return float
     */
    private function getTrainingFactor($defensiveFactor, $offensiveFactor)
    {
        if ($this->preferredTraining == self::PREFERRED_TRAINING_DEFENSIVE) {
            return $defensiveFactor;
        } elseif ($this->preferredTraining == self::PREFERRED_TRAINING_OFFENSIVE) {
            return $offensiveFactor;
        } else {
            return 0.5;
        }
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

    /**
     * @param Player $player
     */
    public function train(Player $player)
    {
        $defensive = ceil($this->skill * $this->getTrainingFactorDefensive());
        $offensive = ceil($this->skill * $this->getTrainingFactorOffensive());

        $player->addTrainingValueDefense($defensive);
        $player->addTrainingValueOffense($offensive);
    }
}
