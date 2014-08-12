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
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->createTeam('Schwarz-Grün Hannover');
        $this->createTeam('Rot-Weiss München');
        $this->createTeam('Blau-Weiss Gelsenkirchen');
        $this->createTeam('Schwarz-Rot Leverkusen');
        $this->createTeam('Grün-Weiss Wolfsburg');
        $this->createTeam('Schwarz-Grün Mönchengladbach');
        $this->createTeam('Rot-Weiss Mainz');
        $this->createTeam('Rot-Weiss Augsburg');
        $this->createTeam('Blau-Weiss Hoffenheim');
        $this->createTeam('Schwarz-Gelb Dortmund');
        $this->createTeam('Blau-Weiss Berlin');
        $this->createTeam('Grün-Weiss Bremen');
        $this->createTeam('Schwarz-Rot Frankfurt');
        $this->createTeam('Schwarz-Rot Freiburg');
        $this->createTeam('Rot-Weiss Stuttgart');
        $this->createTeam('Blau-Weiss Hamburg');
        $this->createTeam('Rot-Weiss Köln');
        $this->createTeam('Blau-Weiss Paderborn');

        $this->manager->flush();
    }

    /**
     * @param string $name
     */
    private function createTeam($name)
    {
        $team = new Team();
        $team->setName($name);

        /** @var League $league */
        $league = $this->getReference('league1');
        $team->setLeague($league);

        $this->manager->persist($team);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
