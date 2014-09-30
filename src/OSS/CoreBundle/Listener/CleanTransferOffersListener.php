<?php

namespace OSS\CoreBundle\Listener;

use OSS\CoreBundle\Event\GameDateEvent;
use OSS\CoreBundle\Repository\TransferOfferRepository;

class CleanTransferOffersListener
{
    /**
     * @var TransferOfferRepository
     */
    private $transferOfferRepository;

    /**
     * @param TransferOfferRepository $transferOfferRepository
     */
    public function __construct(TransferOfferRepository $transferOfferRepository)
    {
        $this->transferOfferRepository = $transferOfferRepository;
    }

    /**
     * @param GameDateEvent $event
     */
    public function execute(GameDateEvent $event)
    {
        if ($event->getGameDate()->getWeek() == 1) {
            $this->transferOfferRepository->removeAll();
        }
    }
}
