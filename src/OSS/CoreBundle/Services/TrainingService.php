<?php

namespace OSS\CoreBundle\Services;

use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\Team;

class TrainingService
{
    /**
     * @var EntityRepository
     */
    private $teamRepository;

    /**
     * @param EntityRepository $repository
     */
    public function __construct(EntityRepository $repository)
    {
        $this->teamRepository = $repository;
    }

    public function handleTraining()
    {
        /** @var Team[] $teams */
        $teams = $this->teamRepository->findAll();
        foreach ($teams as $team) {
            $team->train();
        }
    }

    public function handleTrainingValueReduction()
    {
        /** @var Team[] $teams */
        $teams = $this->teamRepository->findAll();
        foreach ($teams as $team) {
            foreach ($team->getPlayers() as $player) {
                $player->decreaseTrainingValues();
            }
        }
    }
}
