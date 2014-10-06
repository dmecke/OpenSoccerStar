<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Trainer
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorTackling = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorPassing = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorShooting = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorHeading = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorSpeed = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorCrossing = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorTechnics = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorIntelligence = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorSafety = 10;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingFactorDribbling = 10;

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
     * @param PlayerSkills $skills
     */
    public function train(PlayerSkills $skills)
    {
        $skills->addTrainingValueTackling($this->getTrainingAddValue($this->trainingFactorTackling));
        $skills->addTrainingValuePassing($this->getTrainingAddValue($this->trainingFactorPassing));
        $skills->addTrainingValueShooting($this->getTrainingAddValue($this->trainingFactorShooting));
        $skills->addTrainingValueHeading($this->getTrainingAddValue($this->trainingFactorHeading));
        $skills->addTrainingValueSpeed($this->getTrainingAddValue($this->trainingFactorSpeed));
        $skills->addTrainingValueCrossing($this->getTrainingAddValue($this->trainingFactorCrossing));
        $skills->addTrainingValueTechnics($this->getTrainingAddValue($this->trainingFactorTechnics));
        $skills->addTrainingValueIntelligence($this->getTrainingAddValue($this->trainingFactorIntelligence));
        $skills->addTrainingValueSafety($this->getTrainingAddValue($this->trainingFactorSafety));
        $skills->addTrainingValueDribbling($this->getTrainingAddValue($this->trainingFactorDribbling));
    }

    /**
     * @param int $trainingFactor
     * 
     * @return int
     */
    private function getTrainingAddValue($trainingFactor)
    {
        return ceil($this->skill * 5 * $trainingFactor / 100);
    }

    /**
     * @return int
     */
    public function getTrainingFactorTackling()
    {
        return $this->trainingFactorTackling;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorTackling($factor)
    {
        $this->trainingFactorTackling = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorPassing()
    {
        return $this->trainingFactorPassing;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorPassing($factor)
    {
        $this->trainingFactorPassing = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorShooting()
    {
        return $this->trainingFactorShooting;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorShooting($factor)
    {
        $this->trainingFactorShooting = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorHeading()
    {
        return $this->trainingFactorHeading;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorHeading($factor)
    {
        $this->trainingFactorHeading = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorSpeed()
    {
        return $this->trainingFactorSpeed;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorSpeed($factor)
    {
        $this->trainingFactorSpeed = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorCrossing()
    {
        return $this->trainingFactorCrossing;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorCrossing($factor)
    {
        $this->trainingFactorCrossing = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorTechnics()
    {
        return $this->trainingFactorTechnics;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorTechnics($factor)
    {
        $this->trainingFactorTechnics = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorIntelligence()
    {
        return $this->trainingFactorIntelligence;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorIntelligence($factor)
    {
        $this->trainingFactorIntelligence = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorSafety()
    {
        return $this->trainingFactorSafety;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorSafety($factor)
    {
        $this->trainingFactorSafety = $factor;
    }

    /**
     * @return int
     */
    public function getTrainingFactorDribbling()
    {
        return $this->trainingFactorDribbling;
    }

    /**
     * @param int $factor
     */
    public function setTrainingFactorDribbling($factor)
    {
        $this->trainingFactorDribbling = $factor;
    }

}
