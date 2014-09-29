<?php

namespace OSS\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\TransferOffer;
use OSS\CoreBundle\Repository\TransferOfferRepository;

class TransferService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TransferOfferRepository
     */
    private $transferOfferRepository;

    /**
     * @param EntityManager $entityManager
     * @param TransferOfferRepository $transferOfferRepository
     */
    public function __construct(EntityManager $entityManager, TransferOfferRepository $transferOfferRepository)
    {
        $this->entityManager = $entityManager;
        $this->transferOfferRepository = $transferOfferRepository;
    }

    public function decideOnTransferOffers()
    {
        /** @var TransferOffer $transferOffer */
        foreach ($this->transferOfferRepository->findAll() as $transferOffer) {
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
        if ($transferOffer->isSellAccepted()) {
            $transfer = $transferOffer->execute($gameDate);
            $this->entityManager->persist($transfer);
            $this->entityManager->remove($transferOffer);
        } elseif ($transferOffer->isSellDenied()) {
            $this->entityManager->remove($transferOffer);
        }
    }

    public function createTransferOffers()
    {
        $players = $this->entityManager->getRepository('CoreBundle:Player')->findAll();
        $managers = $this->entityManager->getRepository('CoreBundle:Manager')->findAll();
        foreach ($managers as $manager) {
            $pickedPlayer = $manager->selectBestFittingPlayer($this->pickPlayersToInvestigate($players));
            if ($pickedPlayer !== null) {
                $transferOffer = $manager->createTransferOffer($pickedPlayer, $manager);
                $this->entityManager->persist($transferOffer);
            }
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
