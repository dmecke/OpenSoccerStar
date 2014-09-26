<?php

namespace OSS\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Fixture;
use OSS\CoreBundle\Entity\Scorer;
use OSS\CoreBundle\Manager\ScorerManager;

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
