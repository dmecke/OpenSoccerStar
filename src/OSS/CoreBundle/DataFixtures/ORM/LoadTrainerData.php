<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use OSS\CoreBundle\Entity\Trainer;

class LoadTrainerData extends AbstractTeamMemberFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param int $teamIndex
     *
     * @return Trainer
     */
    protected function createEntity($teamIndex)
    {
        $trainer = new Trainer();
        $trainer->setPreferredTraining(rand(1, 3));
        $trainer->setSkill(max(1, min(100, round(rand(1, 100) / $teamIndex * 5))));

        return $trainer;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 5;
    }
}
