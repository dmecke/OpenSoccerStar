<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use OSS\CoreBundle\Entity\Manager;
use OSS\MatchBundle\Entity\Team;

class LoadManagerData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var int
     */
    private $playerCounter = 1;

    /**
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $faker = FakerFactory::create('de_DE');

        for ($i = 1; $i <= 18; $i++) {
            /** @var Team $team */
            $team = $this->getReference('team' . $i);

            $manager = new Manager();
            $manager->setName($faker->firstNameMale . ' '. $faker->lastName);
            $manager->setPreferredSkill(rand(1, 3));
            $manager->setMoneyBehaviour(rand(1, 3));
            $manager->setTeam($team);
            $objectManager->persist($manager);
        }

        $objectManager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}
