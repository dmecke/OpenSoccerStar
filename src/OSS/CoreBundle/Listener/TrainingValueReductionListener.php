<?php

namespace OSS\CoreBundle\Listener;

use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\Team;

class TrainingValueReductionListener
{
    /**
     * @var EntityRepository
     */
    private $teamRepository;

    /**
     * @param EntityRepository $teamRepository
     */
    public function __construct(EntityRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function execute()
    {
        foreach ($this->findAllTeams() as $team) {
            foreach ($team->getPlayers() as $player) {
                $player->getSkills()->decreaseTrainingValues();
            }
        }
    }

    /**
     * @return Team[]
     */
    private function findAllTeams()
    {
        return $this->teamRepository->findAll();
    }
}
