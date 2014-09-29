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
        foreach ($this->getAllTeams() as $team) {
            $team->train();
        }
    }

    public function handleTrainingValueReduction()
    {
        foreach ($this->getAllTeams() as $team) {
            foreach ($team->getPlayers() as $player) {
                $player->decreaseTrainingValues();
            }
        }
    }

    public function handleSkillUpdate()
    {
        foreach ($this->getAllTeams() as $team) {
            foreach ($team->getPlayers() as $player) {
                $player->updateSkills();
            }
        }
    }

    /**
     * @return Team[]
     */
    private function getAllTeams()
    {
        return $this->teamRepository->findAll();
    }
}
