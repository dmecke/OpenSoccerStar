<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\CoreBundle\Transfer\ScoreCalculator;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\OneToOne(targetEntity="Team", inversedBy="manager")
     */
    private $team;

    /**
     * @var ScoreCalculator
     */
    private $transferScoreCalculator;

    public function __construct()
    {
        $this->initTransferScoreCalculator();
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
        if (null === $this->team->getManager()) {
            $this->team->setManager($this);
        }
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

    /**
     * @param Player[] $playersToInvestigate
     *
     * @return null|Player
     */
    public function selectBestFittingPlayer(array $playersToInvestigate)
    {
        $pickedPlayer = null;
        $bestScore = 0;
        foreach ($playersToInvestigate as $player) {
            if ($player->hasTeam() && $player->getTeam()->equals($this->team)) continue;
            $score = $this->transferScoreCalculator->calculateBuyScore($player);
            if ($score > $bestScore) {
                $pickedPlayer = $player;
                $bestScore = $score;
            }
        }

        return $pickedPlayer;
    }

    /**
     * @param Player $player
     *
     * @return TransferOffer
     */
    public function createTransferOffer(Player $player)
    {
        $transfer = new TransferOffer();
        $transfer->setPlayer($player);
        $transfer->setOriginTeam($player->getTeam());
        $transfer->setTargetTeam($this->team);
        $transfer->setAmount($player->getMarketValue());

        return $transfer;
    }

    /**
     * @param Player $player
     *
     * @return int
     */
    public function calculateSellScore(Player $player)
    {
        return $this->transferScoreCalculator->calculateSellScore($player);
    }

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function isSellAccepted(Player $player)
    {
        return $this->acceptTransferOffer($this->calculateSellScore($player));
    }

    /**
     * @param Player $player
     *
     * @return bool
     */
    public function isSellDenied(Player $player)
    {
        return $this->denyTransferOffer($this->calculateSellScore($player));
    }

    /**
     * @ORM\PostLoad
     */
    public function initTransferScoreCalculator()
    {
        $this->transferScoreCalculator = new ScoreCalculator($this);
    }
}
