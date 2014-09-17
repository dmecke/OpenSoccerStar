<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

class LoadPlayerData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var int
     */
    private $playerCounter = 1;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $faker = FakerFactory::create('de_DE');

        for ($i = 1; $i <= 18; $i++) {
            /** @var Team $team */
            $team = $this->getReference('team' . $i);

            for ($j = 1; $j <= 11; $j++) {
                $player = new Player();
                $player->setName($faker->firstNameMale . ' '. $faker->lastName);
                $player->setSkillDefense(rand(1, 100));
                $player->setSkillOffense(rand(1, 100));
                $team->addPlayer($player);
                $this->manager->persist($player);
            }

        }

        $this->manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
