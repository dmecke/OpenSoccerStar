<?php

namespace OSS\CoreBundle\Listener;

use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Event\GameDateEvent;

class SkillUpdateListener
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

    /**
     * @param GameDateEvent $event
     */
    public function execute(GameDateEvent $event)
    {
        if (!in_array($event->getGameDate()->getWeek(), array(17, 34))) {
            return;
        }

        foreach ($this->findAllTeams() as $team) {
            foreach ($team->getPlayers() as $player) {
                $player->updateSkills();
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
