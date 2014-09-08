<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OSS\LeagueBundle\Entity\League;
use OSS\MatchBundle\Entity\Team;

class LoadTeamData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var int
     */
    private $teamCounter = 1;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->createTeam('Rot-Weiss München', 140000000);
        $this->createTeam('Schwarz-Gelb Dortmund', 68000000);
        $this->createTeam('Blau-Weiss Gelsenkirchen', 80000000);
        $this->createTeam('Schwarz-Rot Leverkusen', 48000000);
        $this->createTeam('Grün-Weiss Wolfsburg', 50000000);
        $this->createTeam('Schwarz-Grün Mönchengladbach', 34500000);
        $this->createTeam('Rot-Weiss Mainz', 24000000);
        $this->createTeam('Rot-Weiss Augsburg', 17000000);
        $this->createTeam('Blau-Weiss Hoffenheim', 30000000);
        $this->createTeam('Schwarz-Grün Hannover', 33000000);
        $this->createTeam('Blau-Weiss Berlin', 28000000);
        $this->createTeam('Grün-Weiss Bremen', 35000000);
        $this->createTeam('Schwarz-Rot Frankfurt', 30000000);
        $this->createTeam('Schwarz-Rot Freiburg', 16100000);
        $this->createTeam('Rot-Weiss Stuttgart', 40000000);
        $this->createTeam('Blau-Weiss Hamburg', 43500000);
        $this->createTeam('Rot-Weiss Köln', 15000000);
        $this->createTeam('Blau-Weiss Paderborn', 12000000);

        $this->manager->flush();
    }

    /**
     * @param string $name
     * @param int $money
     */
    private function createTeam($name, $money)
    {
        $team = new Team();
        $team->setName($name);
        $team->setMoney($money);

        /** @var League $league */
        $league = $this->getReference('league1');
        $team->setLeague($league);

        $this->manager->persist($team);

        $this->addReference('team' . $this->teamCounter++, $team);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
