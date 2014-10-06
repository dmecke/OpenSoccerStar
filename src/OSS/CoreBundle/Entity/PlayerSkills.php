<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlayerSkills implements PlayerSkillsAverageInterface
{
    /**
     * @var int $playerId
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Player
     * 
     * @ORM\OneToOne(targetEntity="Player", cascade={"all"})
     */
    private $player;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $tackling = 1;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $passing = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $shooting = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $heading = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $speed = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $crossing = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $technics = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $intelligence = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $safety = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $dribbling = 1;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $changeTackling = 0;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $changePassing = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeShooting = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeHeading = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeSpeed = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeCrossing = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeTechnics = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeIntelligence = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeSafety = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $changeDribbling = 0;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $trainingValueTackling = 0;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $trainingValuePassing = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueShooting = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueHeading = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueSpeed = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueCrossing = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueTechnics = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueIntelligence = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueSafety = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $trainingValueDribbling = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @return int
     */
    public function getTackling()
    {
        return $this->tackling;
    }

    /**
     * @return int
     */
    public function getPassing()
    {
        return $this->passing;
    }

    /**
     * @return int
     */
    public function getShooting()
    {
        return $this->shooting;
    }

    /**
     * @return int
     */
    public function getCrossing()
    {
        return $this->crossing;
    }

    /**
     * @return int
     */
    public function getDribbling()
    {
        return $this->dribbling;
    }

    /**
     * @return int
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @return int
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * @return int
     */
    public function getSafety()
    {
        return $this->safety;
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return int
     */
    public function getTechnics()
    {
        return $this->technics;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;
        if (null === $player->getSkills()) {
            $player->setSkills($this);
        }
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param int $amount
     */
    public function setCrossing($amount)
    {
        $this->setSkill('crossing', $amount);
    }

    /**
     * @param int $amount
     */
    public function setTechnics($amount)
    {
        $this->setSkill('technics', $amount);
    }

    /**
     * @param int $amount
     */
    public function setSpeed($amount)
    {
        $this->setSkill('speed', $amount);
    }

    /**
     * @param int $amount
     */
    public function setHeading($amount)
    {
        $this->setSkill('heading', $amount);
    }

    /**
     * @param int $amount
     */
    public function setIntelligence($amount)
    {
        $this->setSkill('intelligence', $amount);
    }

    /**
     * @param int $amount
     */
    public function setSafety($amount)
    {
        $this->setSkill('safety', $amount);
    }

    /**
     * @param int $amount
     */
    public function setDribbling($amount)
    {
        $this->setSkill('dribbling', $amount);
    }

    /**
     * @param int $amount
     */
    public function setTackling($amount)
    {
        $this->setSkill('tackling', $amount);
    }

    /**
     * @param int $amount
     */
    public function setPassing($amount)
    {
        $this->setSkill('passing', $amount);
    }

    /**
     * @param int $amount
     */
    public function setShooting($amount)
    {
        $this->setSkill('shooting', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseTackling($amount)
    {
        $this->increaseSkill('tackling', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseTackling($amount)
    {
        $this->decreaseSkill('tackling', $amount);
    }

    /**
     * @param int $amount
     */
    public function increasePassing($amount)
    {
        $this->increaseSkill('passing', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreasePassing($amount)
    {
        $this->decreaseSkill('passing', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseShooting($amount)
    {
        $this->increaseSkill('shooting', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseShooting($amount)
    {
        $this->decreaseSkill('shooting', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseHeading($amount)
    {
        $this->increaseSkill('heading', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseHeading($amount)
    {
        $this->decreaseSkill('heading', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseSpeed($amount)
    {
        $this->increaseSkill('speed', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseSpeed($amount)
    {
        $this->decreaseSkill('speed', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseCrossing($amount)
    {
        $this->increaseSkill('crossing', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseCrossing($amount)
    {
        $this->decreaseSkill('crossing', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseTechnics($amount)
    {
        $this->increaseSkill('technics', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseTechnics($amount)
    {
        $this->decreaseSkill('technics', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseIntelligence($amount)
    {
        $this->increaseSkill('intelligence', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseIntelligence($amount)
    {
        $this->decreaseSkill('intelligence', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseSafety($amount)
    {
        $this->increaseSkill('safety', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseSafety($amount)
    {
        $this->decreaseSkill('safety', $amount);
    }

    /**
     * @param int $amount
     */
    public function increaseDribbling($amount)
    {
        $this->increaseSkill('dribbling', $amount);
    }

    /**
     * @param int $amount
     */
    public function decreaseDribbling($amount)
    {
        $this->decreaseSkill('dribbling', $amount);
    }

    /**
     * @return float
     */
    public function getAverage()
    {
        return ($this->tackling + $this->passing + $this->shooting + $this->heading + $this->speed + $this->crossing + $this->technics + $this->intelligence + $this->safety + $this->dribbling) / 10;
    }

    public function initWithRandomValues()
    {
        $this->tackling = rand(1, 100);
        $this->passing = rand(1, 100);
        $this->shooting = rand(1, 100);
        $this->heading = rand(1, 100);
        $this->speed = rand(1, 100);
        $this->crossing = rand(1, 100);
        $this->technics = rand(1, 100);
        $this->intelligence = rand(1, 100);
        $this->safety = rand(1, 100);
        $this->dribbling = rand(1, 100);
    }

    /**
     * @param int $value
     */
    public function setAll($value)
    {
        $this->tackling = $value;
        $this->passing = $value;
        $this->shooting = $value;
        $this->heading = $value;
        $this->speed = $value;
        $this->crossing = $value;
        $this->technics = $value;
        $this->intelligence = $value;
        $this->safety = $value;
        $this->dribbling = $value;
    }

    /**
     * @param int $value
     */
    public function setAllTrainingValues($value)
    {
        $this->trainingValueTackling = $value;
        $this->trainingValuePassing = $value;
        $this->trainingValueShooting = $value;
        $this->trainingValueHeading = $value;
        $this->trainingValueSpeed = $value;
        $this->trainingValueCrossing = $value;
        $this->trainingValueTechnics = $value;
        $this->trainingValueIntelligence = $value;
        $this->trainingValueSafety = $value;
        $this->trainingValueDribbling = $value;
    }

    /**
     * @return int
     */
    public function getMarketValue()
    {
        return round(pow($this->getAverage(), 6) / 10000);
    }

    /**
     * @return int
     */
    public function getTrainingValueTackling()
    {
        return $this->trainingValueTackling;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueTackling($amount)
    {
        $this->trainingValueTackling = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValuePassing()
    {
        return $this->trainingValuePassing;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValuePassing($amount)
    {
        $this->trainingValuePassing = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueShooting()
    {
        return $this->trainingValueShooting;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueShooting($amount)
    {
        $this->trainingValueShooting = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueHeading()
    {
        return $this->trainingValueHeading;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueHeading($amount)
    {
        $this->trainingValueHeading = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueSpeed()
    {
        return $this->trainingValueSpeed;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueSpeed($amount)
    {
        $this->trainingValueSpeed = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueCrossing()
    {
        return $this->trainingValueCrossing;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueCrossing($amount)
    {
        $this->trainingValueCrossing = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueTechnics()
    {
        return $this->trainingValueTechnics;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueTechnics($amount)
    {
        $this->trainingValueTechnics = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueIntelligence()
    {
        return $this->trainingValueIntelligence;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueIntelligence($amount)
    {
        $this->trainingValueIntelligence = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueSafety()
    {
        return $this->trainingValueSafety;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueSafety($amount)
    {
        $this->trainingValueSafety = $amount;
    }

    /**
     * @return int
     */
    public function getTrainingValueDribbling()
    {
        return $this->trainingValueDribbling;
    }

    /**
     * @param int $amount
     */
    public function setTrainingValueDribbling($amount)
    {
        $this->trainingValueDribbling = $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueTackling($amount)
    {
        $this->trainingValueTackling += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValuePassing($amount)
    {
        $this->trainingValuePassing += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueShooting($amount)
    {
        $this->trainingValueShooting += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueHeading($amount)
    {
        $this->trainingValueHeading += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueSpeed($amount)
    {
        $this->trainingValueSpeed += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueCrossing($amount)
    {
        $this->trainingValueCrossing += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueTechnics($amount)
    {
        $this->trainingValueTechnics += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueIntelligence($amount)
    {
        $this->trainingValueIntelligence += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueSafety($amount)
    {
        $this->trainingValueSafety += $amount;
    }

    /**
     * @param int $amount
     */
    public function addTrainingValueDribbling($amount)
    {
        $this->trainingValueDribbling += $amount;
    }

    /**
     * @return int
     */
    public function getChangeTackling()
    {
        return $this->changeTackling;
    }

    /**
     * @return int
     */
    public function getChangePassing()
    {
        return $this->changePassing;
    }

    /**
     * @return int
     */
    public function getChangeShooting()
    {
        return $this->changeShooting;
    }

    /**
     * @return int
     */
    public function getChangeHeading()
    {
        return $this->changeHeading;
    }

    /**
     * @return int
     */
    public function getChangeSpeed()
    {
        return $this->changeSpeed;
    }

    /**
     * @return int
     */
    public function getChangeCrossing()
    {
        return $this->changeCrossing;
    }

    /**
     * @return int
     */
    public function getChangeTechnics()
    {
        return $this->changeTechnics;
    }

    /**
     * @return int
     */
    public function getChangeIntelligence()
    {
        return $this->changeIntelligence;
    }

    /**
     * @return int
     */
    public function getChangeSafety()
    {
        return $this->changeSafety;
    }

    /**
     * @return int
     */
    public function getChangeDribbling()
    {
        return $this->changeDribbling;
    }

    public function decreaseTrainingValues()
    {
        $this->trainingValueTackling -= 5;
        $this->trainingValuePassing -= 5;
        $this->trainingValueShooting -= 5;
        $this->trainingValueHeading -= 5;
        $this->trainingValueSpeed -= 5;
        $this->trainingValueCrossing -= 5;
        $this->trainingValueTechnics -= 5;
        $this->trainingValueIntelligence -= 5;
        $this->trainingValueSafety -= 5;
        $this->trainingValueDribbling -= 5;
    }

    public function updateSkills()
    {
        $this->updateSkill('tackling');
        $this->updateSkill('passing');
        $this->updateSkill('shooting');
        $this->updateSkill('heading');
        $this->updateSkill('speed');
        $this->updateSkill('crossing');
        $this->updateSkill('technics');
        $this->updateSkill('intelligence');
        $this->updateSkill('safety');
        $this->updateSkill('dribbling');
    }

    /**
     * @param string $skill
     */
    private function updateSkill($skill)
    {
        $changeProperty = 'change' . ucfirst($skill);
        $trainingValueProperty = 'trainingValue' . ucfirst($skill);
        $this->$changeProperty = max(-10, min(10, $this->calculateSkillChange($this->$trainingValueProperty)));
        $this->$skill = max(1, min(100, $this->$skill + $this->$changeProperty));
        $this->$trainingValueProperty = 0;
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
     * @param string $skill
     * @param int $amount
     */
    private function increaseSkill($skill, $amount)
    {
        $this->$skill = max(1, min(100, $this->$skill + $amount));
    }

    /**
     * @param string $skill
     * @param int $amount
     */
    private function decreaseSkill($skill, $amount)
    {
        $this->$skill = max(1, min(100, $this->$skill - $amount));
    }

    /**
     * @param string $skill
     * @param int $amount
     */
    private function setSkill($skill, $amount)
    {
        $this->$skill = max(1, min(100, $amount));
    }

    /**
     * @param PlayerSkillsAverageInterface $a
     * @param PlayerSkillsAverageInterface $b
     *
     * @return bool
     */
    static public function compareAverage(PlayerSkillsAverageInterface $a, PlayerSkillsAverageInterface $b)
    {
        return $a->getAverage() < $b->getAverage();
    }
}
