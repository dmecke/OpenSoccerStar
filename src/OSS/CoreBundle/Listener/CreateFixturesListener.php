<?php

namespace OSS\CoreBundle\Listener;

use OSS\CoreBundle\Event\GameDateEvent;
use OSS\CoreBundle\Services\FixtureService;

class CreateFixturesListener
{
    /**
     * @var FixtureService
     */
    private $fixtureService;

    /**
     * @param FixtureService $fixtureService
     */
    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }

    /**
     * @param GameDateEvent $event
     */
    public function execute(GameDateEvent $event)
    {
        if ($event->getGameDate()->getWeek() == 1) {
            $this->fixtureService->createFixtures($event->getGameDate()->getSeason());
        }
    }
}
