<?php

namespace OSS\LeagueBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\LeagueBundle\Entity\Scorer;
use OSS\LeagueBundle\Manager\ScorerManager;
use OSS\MatchBundle\Entity\Fixture;

class LeagueService
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

    /**
     * @param Fixture[] $fixtures
     *
     * @return Scorer[]
     */
    public function getScorer($fixtures)
    {
        $scorerManager = new ScorerManager();
        foreach ($fixtures as $fixture) {
            foreach ($fixture->getGoalEvents() as $event) {
                $scorer = $scorerManager->addAndGetByPlayer($event->getPlayer());
                $scorer->incrementGoals();
            }
        }

        return $scorerManager->getAllOrdered();
    }
}
