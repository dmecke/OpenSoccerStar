<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Entity\Trainer;

class TrainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Trainer
     */
    private $trainer;

    /**
     * @var Player
     */
    private $player;

    public function setUp()
    {
        $this->trainer = new Trainer();
    }

    public function tearDown()
    {
        $this->trainer = null;
        $this->player = null;
    }

    /**
     * @param int $skill
     * @param int $preferredTraining
     */
    private function setUpTrainer($skill, $preferredTraining)
    {
        $this->trainer->setSkill($skill);
        $this->trainer->setPreferredTraining($preferredTraining);
    }

    /**
     * @param int $trainingValueDefense
     * @param int $trainingValueOffense
     */
    private function setUpPlayer($trainingValueDefense, $trainingValueOffense)
    {
        $this->player = new Player();
        $this->player->setTrainingValueDefense($trainingValueDefense);
        $this->player->setTrainingValueOffense($trainingValueOffense);
    }

    public function testPreferredTraining()
    {
        $this->assertEquals(Trainer::PREFERRED_TRAINING_NEUTRAL, $this->trainer->getPreferredTraining());
    }

    public function testSetAndGetPreferredTrainingDefensive()
    {
        $this->trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_DEFENSIVE);
        $this->assertEquals(Trainer::PREFERRED_TRAINING_DEFENSIVE, $this->trainer->getPreferredTraining());
    }

    public function testSetAndGetPreferredTrainingOffensive()
    {
        $this->trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_OFFENSIVE);
        $this->assertEquals(Trainer::PREFERRED_TRAINING_OFFENSIVE, $this->trainer->getPreferredTraining());
    }

    public function testSkill()
    {
        $this->assertEquals(1, $this->trainer->getSkill());
    }

    public function testSetAndGetSkill()
    {
        $this->trainer->setSkill(100);
        $this->assertEquals(100, $this->trainer->getSkill());
    }

    public function testGetTeam()
    {
        $this->assertNull($this->trainer->getTeam());
    }

    public function testSetAndGetTeam()
    {
        $team = new Team();
        $this->trainer->setTeam($team);
        $this->assertEquals($team, $this->trainer->getTeam());
        $this->assertEquals($this->trainer, $team->getTrainer());
    }

    public function testGetId()
    {
        $this->assertNull($this->trainer->getId());
    }

    public function testSetAndGetId()
    {
        $this->trainer->setId(1);
        $this->assertEquals(1, $this->trainer->getId());
    }

    public function testGetName()
    {
        $this->assertNull($this->trainer->getName());
    }

    public function testSetAndGetName()
    {
        $this->trainer->setName('John Doe');
        $this->assertEquals('John Doe', $this->trainer->getName());
    }

    public function testGetTrainingFactorDefensiveByNeutralTrainer()
    {
        $this->assertEquals(0.5, $this->trainer->getTrainingFactorDefensive());
    }

    public function testGetTrainingFactorOffensiveByNeutralTrainer()
    {
        $this->assertEquals(0.5, $this->trainer->getTrainingFactorOffensive());
    }

    public function testGetTrainingFactorDefensiveByDefensiveTrainer()
    {
        $this->trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_DEFENSIVE);
        $this->assertEquals(0.75, $this->trainer->getTrainingFactorDefensive());
    }

    public function testGetTrainingFactorOffensiveByDefensiveTrainer()
    {
        $this->trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_DEFENSIVE);
        $this->assertEquals(0.25, $this->trainer->getTrainingFactorOffensive());
    }

    public function testGetTrainingFactorDefensiveByOffensiveTrainer()
    {
        $this->trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_OFFENSIVE);
        $this->assertEquals(0.25, $this->trainer->getTrainingFactorDefensive());
    }

    public function testGetTrainingFactorOffensiveByOffensiveTrainer()
    {
        $this->trainer->setPreferredTraining(Trainer::PREFERRED_TRAINING_OFFENSIVE);
        $this->assertEquals(0.75, $this->trainer->getTrainingFactorOffensive());
    }

    public function testTrainByNeutralTrainerWithSkill1()
    {
        $this->setUpPlayer(0, 0);

        $this->trainer->train($this->player);
        $this->assertEquals(1, $this->player->getTrainingValueDefense());
        $this->assertEquals(1, $this->player->getTrainingValueOffense());
    }

    public function testTrainByNeutralTrainerWithSkill1AndBaseValue()
    {
        $this->setUpPlayer(1, 1);

        $this->trainer->train($this->player);
        $this->assertEquals(2, $this->player->getTrainingValueDefense());
        $this->assertEquals(2, $this->player->getTrainingValueOffense());
    }

    public function testTrainByNeutralTrainerWithSkill50()
    {
        $this->setUpPlayer(0, 0);
        $this->trainer->setSkill(50);

        $this->trainer->train($this->player);
        $this->assertEquals(25, $this->player->getTrainingValueDefense());
        $this->assertEquals(25, $this->player->getTrainingValueOffense());
    }

    public function testTrainByDefensiveTrainerWithSkill100()
    {
        $this->setUpPlayer(0, 0);
        $this->setUpTrainer(100, Trainer::PREFERRED_TRAINING_DEFENSIVE);

        $this->trainer->train($this->player);
        $this->assertEquals(75, $this->player->getTrainingValueDefense());
        $this->assertEquals(25, $this->player->getTrainingValueOffense());
    }

    public function testTrainByOffensiveTrainerWithSkill100()
    {
        $this->setUpPlayer(0, 0);
        $this->setUpTrainer(100, Trainer::PREFERRED_TRAINING_OFFENSIVE);

        $this->trainer->train($this->player);
        $this->assertEquals(25, $this->player->getTrainingValueDefense());
        $this->assertEquals(75, $this->player->getTrainingValueOffense());
    }
}
