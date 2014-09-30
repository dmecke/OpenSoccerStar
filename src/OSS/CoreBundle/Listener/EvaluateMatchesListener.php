<?php

namespace OSS\CoreBundle\Listener;

use OSS\CoreBundle\Event\GameDateEvent;
use OSS\CoreBundle\Repository\FixtureRepository;
use OSS\CoreBundle\Services\LineupService;
use OSS\CoreBundle\Services\MatchEvaluationService;

class EvaluateMatchesListener
{
    /**
     * @var FixtureRepository
     */
    private $fixtureRepository;

    /**
     * @var LineupService
     */
    private $lineupService;

    /**
     * @var MatchEvaluationService
     */
    private $matchEvaluationService;

    /**
     * @param FixtureRepository $fixtureRepository
     * @param LineupService $lineupService
     * @param MatchEvaluationService $matchEvaluationService
     */
    public function __construct(FixtureRepository $fixtureRepository, LineupService $lineupService, MatchEvaluationService $matchEvaluationService)
    {
        $this->fixtureRepository = $fixtureRepository;
        $this->lineupService = $lineupService;
        $this->matchEvaluationService = $matchEvaluationService;
    }

    /**
     * @param GameDateEvent $event
     */
    public function execute(GameDateEvent $event)
    {
        $matches = $this->fixtureRepository->findByGameDate($event->getGameDate());
        foreach ($matches as $match) {
            $this->lineupService->createFixtureLineup($match);
            $this->matchEvaluationService->evaluateCompleteMatch($match);
        }
    }
}
