<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\MatchBundle\Entity\Team;

/**
 * @ORM\Entity
 */
class Manager
{
    const PREFERRED_SKILL_DEFENSE = 1;
    const PREFERRED_SKILL_NEUTRAL = 2;
    const PREFERRED_SKILL_OFFENSE = 3;

    const MONEY_BEHAVIOUR_DEFENSIVE = 1;
    const MONEY_BEHAVIOUR_NEUTRAL = 2;
    const MONEY_BEHAVIOUR_OFFENSIVE = 3;

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
    private $preferredSkill;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $moneyBehaviour;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $acceptTransferScoreOffset;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $denyTransferScoreOffset;

    /**
     * @var Team
     *
     * @ORM\OneToOne(targetEntity="OSS\MatchBundle\Entity\Team", inversedBy="manager")
     */
    private $team;

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
    public function getPreferredSkill()
    {
        return $this->preferredSkill;
    }

    /**
     * @param int $preferredSkill
     */
    public function setPreferredSkill($preferredSkill)
    {
        $this->preferredSkill = $preferredSkill;
    }

    /**
     * @return int
     */
    public function getMoneyBehaviour()
    {
        return $this->moneyBehaviour;
    }

    /**
     * @param int $moneyBehaviour
     */
    public function setMoneyBehaviour($moneyBehaviour)
    {
        $this->moneyBehaviour = $moneyBehaviour;
    }

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTransferFactorDefensiveSkill()
    {
        return self::PREFERRED_SKILL_DEFENSE == $this->preferredSkill ? 2 : 1;
    }

    /**
     * @return int
     */
    public function getTransferFactorOffensiveSkill()
    {
        return self::PREFERRED_SKILL_OFFENSE == $this->preferredSkill ? 2 : 1;
    }

    /**
     * @return int
     */
    public function getTransferFactorMoneyBehaviour()
    {
        if (self::MONEY_BEHAVIOUR_DEFENSIVE == $this->moneyBehaviour) {
            return 2;
        } elseif (self::MONEY_BEHAVIOUR_OFFENSIVE == $this->moneyBehaviour) {
            return 0.5;
        } else {
            return 1;
        }
    }

    /**
     * @return int
     */
    public function getAcceptTransferScoreOffset()
    {
        return $this->acceptTransferScoreOffset;
    }

    /**
     * @param int $acceptTransferScoreOffset
     */
    public function setAcceptTransferScoreOffset($acceptTransferScoreOffset)
    {
        $this->acceptTransferScoreOffset = $acceptTransferScoreOffset;
    }

    /**
     * @return int
     */
    public function getDenyTransferScoreOffset()
    {
        return $this->denyTransferScoreOffset;
    }

    /**
     * @param int $denyTransferScoreOffset
     */
    public function setDenyTransferScoreOffset($denyTransferScoreOffset)
    {
        $this->denyTransferScoreOffset = $denyTransferScoreOffset;
    }

    /**
     * @param int $transferOfferScore
     *
     * @return bool
     */
    public function acceptTransferOffer($transferOfferScore)
    {
        return $transferOfferScore >= $this->acceptTransferScoreOffset;
    }

    /**
     * @param int $transferOfferScore
     *
     * @return bool
     */
    public function denyTransferOffer($transferOfferScore)
    {
        return $transferOfferScore <= $this->denyTransferScoreOffset;
    }
}
