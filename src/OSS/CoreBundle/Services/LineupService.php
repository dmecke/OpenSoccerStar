<?php

namespace OSS\CoreBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Fixture;
use OSS\CoreBundle\Entity\Lineup;
use OSS\CoreBundle\Entity\Team;

class LineupService
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
     * @param Fixture $fixture
     */
    public function createFixtureLineup(Fixture $fixture)
    {
        $this->createTeamLineup($fixture, $fixture->getTeamHome());
        $this->createTeamLineup($fixture, $fixture->getTeamAway());
    }

    public function createTeamLineup(Fixture $fixture, Team $team)
    {
        $lineup = new Lineup();
        $lineup->setFixture($fixture);
        $lineup->setTeam($team);
        $players = $team->getLineup();
        $lineup->setPlayer1($players[0]);
        $lineup->setPlayer2($players[1]);
        $lineup->setPlayer3($players[2]);
        $lineup->setPlayer4($players[3]);
        $lineup->setPlayer5($players[4]);
        $lineup->setPlayer6($players[5]);
        $lineup->setPlayer7($players[6]);
        $lineup->setPlayer8($players[7]);
        $lineup->setPlayer9($players[8]);
        $lineup->setPlayer10($players[9]);
        $lineup->setPlayer11($players[10]);
        $this->entityManager->persist($lineup);
    }
}
