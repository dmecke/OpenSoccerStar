<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OSS\CoreBundle\Entity\GameDate;

class LoadGameDateData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $gameDate = new GameDate();

        $manager->persist($gameDate);

        $manager->flush();
    }
}
