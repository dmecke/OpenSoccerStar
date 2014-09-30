<?php

namespace OSS\CoreBundle\Listener;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\GameDate;
use OSS\CoreBundle\Entity\TransferOffer;
use OSS\CoreBundle\Event\GameDateEvent;
use OSS\CoreBundle\Repository\FixtureRepository;
use OSS\CoreBundle\Repository\TransferOfferRepository;

class DecideOnTransferOffersListener
{
    /**
     * @var FixtureRepository
     */
    private $transferOfferRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param TransferOfferRepository $transferOfferRepository
     * @param EntityManager $entityManager
     */
    public function __construct(TransferOfferRepository $transferOfferRepository, EntityManager $entityManager)
    {
        $this->transferOfferRepository = $transferOfferRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param GameDateEvent $event
     */
    public function execute(GameDateEvent $event)
    {
        foreach ($this->findAllTransferOffers() as $transferOffer) {
            $this->decideOnTransferOffer($transferOffer, $event->getGameDate());
        }
    }

    /**
     * @param TransferOffer $transferOffer
     * @param GameDate $gameDate
     */
    private function decideOnTransferOffer(TransferOffer $transferOffer, GameDate $gameDate)
    {
        if ($transferOffer->isSellAccepted()) {
            $transfer = $transferOffer->execute($gameDate);
            $this->entityManager->persist($transfer);
            $this->entityManager->remove($transferOffer);
        } elseif ($transferOffer->isSellDenied()) {
            $this->entityManager->remove($transferOffer);
        }
    }

    /**
     * @return TransferOffer[]
     */
    private function findAllTransferOffers()
    {
        return $this->transferOfferRepository->findAll();
    }
}
