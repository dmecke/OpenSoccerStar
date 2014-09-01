<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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

        for ($i = 1; $i <= 18; $i++) {
            /** @var Team $team */
            $team = $this->getReference('team' . $i);

            for ($j = 1; $j <= 11; $j++) {
                $player = new Player();
                $player->setName('Player ' . $this->playerCounter++);
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
