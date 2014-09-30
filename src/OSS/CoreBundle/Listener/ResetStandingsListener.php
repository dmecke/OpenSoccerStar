<?php

namespace OSS\CoreBundle\Listener;

use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\League;
use OSS\CoreBundle\Event\GameDateEvent;

class ResetStandingsListener
{
    /**
     * @var EntityRepository
     */
    private $leagueRepository;

    /**
     * @param EntityRepository $leagueRepository
     */
    public function __construct(EntityRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param GameDateEvent $event
     */
    public function execute(GameDateEvent $event)
    {
        if ($event->getGameDate()->getWeek() != 1) {
            return;
        }

        foreach ($this->findAllLeagues() as $league) {
            $league->createFinalPositions($event->getGameDate()->getSeason() - 1);
            $league->resetStandings();
        }
    }

    /**
     * @return League[]
     */
    private function findAllLeagues()
    {
        return $this->leagueRepository->findAll();
    }
}
