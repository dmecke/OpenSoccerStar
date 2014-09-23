<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

/**
 * @ORM\Entity
 */
class Transfer
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
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="OSS\MatchBundle\Entity\Player", inversedBy="transfers", fetch="EAGER")
     */
    private $player;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="OSS\MatchBundle\Entity\Team", fetch="EAGER")
     */
    private $originTeam;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="OSS\MatchBundle\Entity\Team", fetch="EAGER")
     */
    private $targetTeam;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $season;

    /**
     * @param TransferOffer $transferOffer
     *
     * @return Transfer
     */
    static public function createFromOffer(TransferOffer $transferOffer)
    {
        $transfer = new Transfer();
        $transfer->setOriginTeam($transferOffer->getOriginTeam());
        $transfer->setTargetTeam($transferOffer->getTargetTeam());
        $transfer->setPlayer($transferOffer->getPlayer());
        $transfer->setAmount($transferOffer->getAmount());

        return $transfer;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return Team
     */
    public function getOriginTeam()
    {
        return $this->originTeam;
    }

    /**
     * @param Team $originTeam
     */
    public function setOriginTeam(Team $originTeam)
    {
        $this->originTeam = $originTeam;
    }

    /**
     * @return Team
     */
    public function getTargetTeam()
    {
        return $this->targetTeam;
    }

    /**
     * @param Team $targetTeam
     */
    public function setTargetTeam(Team $targetTeam)
    {
        $this->targetTeam = $targetTeam;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param int $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }
}
