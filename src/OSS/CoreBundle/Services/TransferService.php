<?php

namespace OSS\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Transfer;
use OSS\CoreBundle\Entity\TransferOffer;
use OSS\CoreBundle\Transfer\ScoreCalculator;

class TransferService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handleTransfers()
    {
        $this->decideOnTransferOffers();
        $this->createTransferOffers();
    }

    private function decideOnTransferOffers()
    {
        $transferOffers = $this->entityManager->getRepository('CoreBundle:TransferOffer')->findAll();
        foreach ($transferOffers as $transferOffer) {
            $this->decideOnTransferOffer($transferOffer);
        }
        $this->entityManager->flush();
    }

    /**
     * @param TransferOffer $transferOffer
     */
    private function decideOnTransferOffer(TransferOffer $transferOffer)
    {
        $gameDate = $this->entityManager->getRepository('CoreBundle:GameDate')->findOneBy(array());
        $transferCalculator = new ScoreCalculator();
        $sellScore = $transferCalculator->calculateSellScore($transferOffer->getOriginTeam()->getManager(), $transferOffer->getPlayer());
        $sellingManager = $transferOffer->getOriginTeam()->getManager();
        if ($sellingManager->acceptTransferOffer($sellScore)) {
            $transfer = Transfer::createFromOffer($transferOffer);
            $transfer->setSeason($gameDate->getSeason());
            $this->entityManager->persist($transfer);

            $transferOffer->getOriginTeam()->addMoney($transferOffer->getAmount());
            $transferOffer->getTargetTeam()->subtractAmount($transferOffer->getAmount());
            $transferOffer->getPlayer()->setTeam($transferOffer->getTargetTeam());
            $this->entityManager->remove($transferOffer);
        } elseif ($sellingManager->denyTransferOffer($sellScore)) {
            $this->entityManager->remove($transferOffer);
        }
    }

    private function createTransferOffers()
    {
        $players = $this->entityManager->getRepository('CoreBundle:Player')->findAll();
        $managers = $this->entityManager->getRepository('CoreBundle:Manager')->findAll();
        foreach ($managers as $manager) {
            $pickedPlayer = $this->selectBestFittingPlayer($manager, $this->pickPlayersToInvestigate($players));
            if ($pickedPlayer !== null) {
                $this->createTransferOffer($pickedPlayer, $manager);
            }
        }
        $this->entityManager->flush();
    }

    /**
     * @param Manager $manager
     * @param Player[] $playersToInvestigate
     *
     * @return null|Player
     */
    public function selectBestFittingPlayer(Manager $manager, array $playersToInvestigate)
    {
        $transferScoreCalculator = new ScoreCalculator();
        $pickedPlayer = null;
        $bestScore = 0;
        foreach ($playersToInvestigate as $player) {
            if ($player->hasTeam() && $player->getTeam()->equals($manager->getTeam())) continue;
            $score = $transferScoreCalculator->calculateBuyScore($manager, $player);
            if ($score > $bestScore) {
                $pickedPlayer = $player;
                $bestScore = $score;
            }
        }

        return $pickedPlayer;
    }

    /**
     * @param Player $player
     * @param Manager $manager
     *
     * @return TransferOffer
     */
    private function createTransferOffer(Player $player, Manager $manager)
    {
        $transfer = new TransferOffer();
        $transfer->setPlayer($player);
        $transfer->setOriginTeam($player->getTeam());
        $transfer->setTargetTeam($manager->getTeam());
        $transfer->setAmount($player->getMarketValue());
        $this->entityManager->persist($transfer);

        return $transfer;
    }

    /**
     * @param Player[] $players
     *
     * @return Player[]
     */
    private function pickPlayersToInvestigate(array $players)
    {
        $playersToInvestiage = array();
        for ($i = 0; $i < 10; $i++) {
            $playersToInvestiage[] = $players[rand(0, count($players) - 1)];
        }

        return $playersToInvestiage;
    }
}
