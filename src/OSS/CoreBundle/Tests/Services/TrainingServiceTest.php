<?php

namespace OSS\CoreBundle\Tests\Services;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Trainer;
use OSS\CoreBundle\Services\TrainingService;

class TrainingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TrainingService
     */
    private $trainingService;

    public function setUp()
    {
        $this->trainingService = new TrainingService();
    }

    public function tearDown()
    {
        $this->trainingService = null;
    }

    public function testTrainByNeutralTrainerWithSkill1()
    {
        $player = new Player();
        $trainer = new Trainer();

        $this->trainingService->train($player, $trainer);
        $this->assertEquals(1, $player->getTrainingValueDefense());
        $this->assertEquals(1, $player->getTrainingValueOffense());
    }

    public function testTrainByNeutralTrainerWithSkill1AndBaseValue()
    {
        $player = new Player();
        $player->setTrainingValueDefense(1);
        $player->setTrainingValueOffense(1);
        $trainer = new Trainer();

        $this->trainingService->train($player, $trainer);
        $this->assertEquals(2, $player->getTrainingValueDefense());
        $this->assertEquals(2, $player->getTrainingValueOffense());
    }

    public function testTrainByNeutralTrainerWithSkill50()
    {
        $player = new Player();
        $trainer = new Trainer();
        $trainer->setSkill(50);

        $this->trainingService->train($player, $trainer);
        $this->assertEquals(25, $player->getTrainingValueDefense());
        $this->assertEquals(25, $player->getTrainingValueOffense());
    }

    public function testTrainByDefensiveTrainerWithSkill100()
    {
        $player = new Player();
        $trainer = new Trainer();
        $trainer->setSkill(100);
        $trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_DEFENSIVE);

        $this->trainingService->train($player, $trainer);
        $this->assertEquals(75, $player->getTrainingValueDefense());
        $this->assertEquals(25, $player->getTrainingValueOffense());
    }

    public function testTrainByOffensiveTrainerWithSkill100()
    {
        $player = new Player();
        $trainer = new Trainer();
        $trainer->setSkill(100);
        $trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_OFFENSIVE);

        $this->trainingService->train($player, $trainer);
        $this->assertEquals(25, $player->getTrainingValueDefense());
        $this->assertEquals(75, $player->getTrainingValueOffense());
    }
}
