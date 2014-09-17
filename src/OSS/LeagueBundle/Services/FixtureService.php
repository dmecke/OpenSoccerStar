<?php

namespace OSS\LeagueBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\LeagueBundle\FixtureGenerator\Generator;
use OSS\MatchBundle\Entity\Fixture;

class FixtureService
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
     * @param int $season
     *
     * @throws \Exception
     */
    public function createFixtures($season)
    {
        $league = $this->entityManager->getRepository('LeagueBundle:League')->findOneBy(array());
        $generator = new Generator(count($league->getTeams()));
        $matches = $generator->createFixtures();
        $listOfTeams = $league->getTeams();

        foreach ($matches as $match) {
            $fixture = new Fixture();
            $fixture->setSeason($season);
            $fixture->setWeek($match->getWeek());
            $fixture->setTeamHome($listOfTeams[$match->getTeamHome() - 1]);
            $fixture->setTeamAway($listOfTeams[$match->getTeamAway() - 1]);

            $this->entityManager->persist($fixture);
        }
        $this->entityManager->flush();

    }
}
