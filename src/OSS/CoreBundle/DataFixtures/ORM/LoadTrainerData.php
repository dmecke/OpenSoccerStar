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
        $factor = array();
        for ($i = 0; $i < 10; $i++) {
            $factor[$i] = 0;
        }
        for ($i = 1; $i <= 100; $i++) {
            $factor[rand(0, 9)]++;
        }

        $trainer = new Trainer();
        $trainer->setTrainingFactorTackling($factor[0]);
        $trainer->setTrainingFactorPassing($factor[1]);
        $trainer->setTrainingFactorShooting($factor[2]);
        $trainer->setTrainingFactorHeading($factor[3]);
        $trainer->setTrainingFactorSpeed($factor[4]);
        $trainer->setTrainingFactorCrossing($factor[5]);
        $trainer->setTrainingFactorTechnics($factor[6]);
        $trainer->setTrainingFactorIntelligence($factor[7]);
        $trainer->setTrainingFactorSafety($factor[8]);
        $trainer->setTrainingFactorDribbling($factor[9]);
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
