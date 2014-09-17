<?php

namespace OSS\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Transfer;
use OSS\CoreBundle\Entity\TransferOffer;
use OSS\CoreBundle\Transfer\ScoreCalculator;
use OSS\MatchBundle\Entity\Player;

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
        $transferCalculator = new ScoreCalculator();
        $transferOffers = $this->entityManager->getRepository('CoreBundle:TransferOffer')->findAll();
        foreach ($transferOffers as $transferOffer) {
            if ($transferCalculator->calculateSell($transferOffer->getOriginTeam()->getManager(), $transferOffer->getPlayer()) >= 100) {
                $transfer = Transfer::createFromOffer($transferOffer);
                $this->entityManager->persist($transfer);

                $transferOffer->getOriginTeam()->addMoney($transferOffer->getAmount());
                $transferOffer->getTargetTeam()->subtractAmount($transferOffer->getAmount());
                $transferOffer->getPlayer()->setTeam($transferOffer->getTargetTeam());
                $this->entityManager->remove($transferOffer);
            } elseif ($transferCalculator->calculateSell($transferOffer->getOriginTeam()->getManager(), $transferOffer->getPlayer()) < 50) {
                $this->entityManager->remove($transferOffer);
            }
        }
        $this->entityManager->flush();
    }

    private function createTransferOffers()
    {
        $players = $this->entityManager->getRepository('MatchBundle:Player')->findAll();
        $managers = $this->entityManager->getRepository('CoreBundle:Manager')->findAll();
        $transferScoreCalculator = new ScoreCalculator();
        foreach ($managers as $manager) {
            $playersToInvestigate = $this->pickPlayersToInvestigate($players);
            $pickedPlayer = null;
            $bestScore = 0;
            foreach ($playersToInvestigate as $player) {
                $score = $transferScoreCalculator->calculateBuy($manager, $player);
                if ($score > $bestScore) {
                    $pickedPlayer = $player;
                    $bestScore = $score;
                }
            }
            if ($pickedPlayer !== null) {
                $transfer = new TransferOffer();
                $transfer->setPlayer($pickedPlayer);
                $transfer->setOriginTeam($pickedPlayer->getTeam());
                $transfer->setTargetTeam($manager->getTeam());
                $transfer->setAmount($pickedPlayer->getMarketValue());
                $this->entityManager->persist($transfer);
            }
        }
        $this->entityManager->flush();
    }

    public function clearTransferlist()
    {
        $transferOffers = $this->entityManager->getRepository('CoreBundle:TransferOffer')->findAll();
        foreach ($transferOffers as $transferOffer) {
            $this->entityManager->remove($transferOffer);
        }

        $this->entityManager->flush();
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
