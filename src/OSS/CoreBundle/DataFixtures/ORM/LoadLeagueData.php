<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OSS\LeagueBundle\Entity\League;

class LoadLeagueData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $league = new League();

        $manager->persist($league);

        $manager->flush();

        $this->addReference('league1', $league);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
