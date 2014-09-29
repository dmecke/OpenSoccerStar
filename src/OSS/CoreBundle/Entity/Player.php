<?php

namespace OSS\CoreBundle\Entity;

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
    private $skillDefense = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $skillOffense = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $skillChangeDefense = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $skillChangeOffense = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueDefense = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueOffense = 0;

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

    /**
     * @return int
     */
    public function getTrainingValueDefense()
    {
        return $this->trainingValueDefense;
    }

    /**
     * @param int $value
     */
    public function setTrainingValueDefense($value)
    {
        $this->trainingValueDefense = $value;
    }

    /**
     * @return int
     */
    public function getTrainingValueOffense()
    {
        return $this->trainingValueOffense;
    }

    /**
     * @param int $value
     */
    public function setTrainingValueOffense($value)
    {
        $this->trainingValueOffense = $value;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueDefense($amount)
    {
        $this->trainingValueDefense += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueOffense($amount)
    {
        $this->trainingValueOffense += $amount;
    }

    public function decreaseTrainingValues()
    {
        $this->trainingValueDefense -= floor($this->skillDefense * 0.5);
        $this->trainingValueOffense -= floor($this->skillOffense * 0.5);
    }

    public function updateSkills()
    {
        $this->skillChangeDefense = max(0, min(100, $this->calculateSkillChange($this->trainingValueDefense)));
        $this->skillDefense += $this->skillChangeDefense;
        $this->trainingValueDefense = 0;

        $this->skillChangeOffense += max(0, min(100, $this->calculateSkillChange($this->trainingValueOffense)));
        $this->skillOffense += $this->skillChangeOffense;
        $this->trainingValueOffense = 0;
    }

    /**
     * @param int $trainingValue
     *
     * @return int
     */
    private function calculateSkillChange($trainingValue)
    {
        $change = 0;
        for ($i = 0; $i < abs($trainingValue) && $change < 10; $i++) {
            if (rand(1, 100) == 1) {
                $change++;
            }
        }

        if ($trainingValue < 0) {
            $change *= -1;
        }

        return $change;
    }

    /**
     * @return int
     */
    public function getSkillChangeDefense()
    {
        return $this->skillChangeDefense;
    }

    /**
     * @return int
     */
    public function getSkillChangeOffense()
    {
        return $this->skillChangeOffense;
    }
}
