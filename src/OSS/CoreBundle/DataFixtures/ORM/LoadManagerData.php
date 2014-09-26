<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use OSS\CoreBundle\Entity\Manager;

class LoadManagerData extends AbstractTeamMemberFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @param int $teamIndex
     *
     * @return Manager
     */
    protected function createEntity($teamIndex)
    {
        $manager = new Manager();
        $manager->setPreferredSkill(rand(1, 3));
        $manager->setMoneyBehaviour(rand(1, 3));
        $manager->setAcceptTransferScoreOffset(rand(75, 200));
        $manager->setDenyTransferScoreOffset(rand(25, 75));

        return $manager;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}
