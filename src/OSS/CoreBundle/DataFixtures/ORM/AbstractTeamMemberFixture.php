<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Trainer;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

abstract class AbstractTeamMemberFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var int
     */
    protected $numberOfEntitiesToCreate = 1;

    /**
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $faker = FakerFactory::create('de_DE');

        for ($i = 1; $i <= 18; $i++) {
            /** @var Team $team */
            $team = $this->getReference('team' . $i);

            for ($j = 1; $j <= $this->numberOfEntitiesToCreate; $j++) {
                $entity = $this->createEntity($i);
                $entity->setName($faker->firstNameMale . ' ' . $faker->lastName);
                $entity->setTeam($team);
                $objectManager->persist($entity);
            }
        }

        $objectManager->flush();
    }

    /**
     * @param int
     *
     * @return Trainer|Manager|Player
     */
    abstract protected function createEntity($teamIndex);
}
