<?php

namespace OSS\CoreBundle\Listener;

use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\Team;

class TrainingListener
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
            $team->train();
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
