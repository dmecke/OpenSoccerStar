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
        $factor = array();
        for ($i = 0; $i < 10; $i++) {
            $factor[$i] = 0;
        }
        for ($i = 1; $i <= 100; $i++) {
            $factor[rand(0, 9)]++;
        }

        $manager = new Manager();
        $manager->setTransferFactorTackling($factor[0]);
        $manager->setTransferFactorPassing($factor[1]);
        $manager->setTransferFactorShooting($factor[2]);
        $manager->setTransferFactorHeading($factor[3]);
        $manager->setTransferFactorSpeed($factor[4]);
        $manager->setTransferFactorCrossing($factor[5]);
        $manager->setTransferFactorTechnics($factor[6]);
        $manager->setTransferFactorIntelligence($factor[7]);
        $manager->setTransferFactorSafety($factor[8]);
        $manager->setTransferFactorDribbling($factor[9]);
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
