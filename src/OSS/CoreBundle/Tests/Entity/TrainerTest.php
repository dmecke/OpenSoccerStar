<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Entity\Trainer;

class TrainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Trainer
     */
    private $trainer;

    /**
     * @var PlayerSkills
     */
    private $skills;

    public function setUp()
    {
        $this->trainer = new Trainer();
        $this->skills = new PlayerSkills();
    }

    public function tearDown()
    {
        $this->trainer = null;
        $this->skills = null;
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
    
    public function testTrainingFactors()
    {
        $allFactors = $this->trainer->getTrainingFactorTackling() + $this->trainer->getTrainingFactorPassing() + $this->trainer->getTrainingFactorShooting() + $this->trainer->getTrainingFactorHeading() + $this->trainer->getTrainingFactorSpeed() + $this->trainer->getTrainingFactorCrossing() + $this->trainer->getTrainingFactorTechnics() + $this->trainer->getTrainingFactorIntelligence() + $this->trainer->getTrainingFactorSafety() + $this->trainer->getTrainingFactorDribbling();
        $this->assertEquals(100, $allFactors);
    }

    public function testTrainWithSkill1()
    {
        $this->trainer->train($this->skills);
        $this->assertEquals(1, $this->skills->getTrainingValueTackling());
        $this->assertEquals(1, $this->skills->getTrainingValuePassing());
        $this->assertEquals(1, $this->skills->getTrainingValueShooting());
        $this->assertEquals(1, $this->skills->getTrainingValueHeading());
        $this->assertEquals(1, $this->skills->getTrainingValueSpeed());
        $this->assertEquals(1, $this->skills->getTrainingValueCrossing());
        $this->assertEquals(1, $this->skills->getTrainingValueTechnics());
        $this->assertEquals(1, $this->skills->getTrainingValueIntelligence());
        $this->assertEquals(1, $this->skills->getTrainingValueSafety());
        $this->assertEquals(1, $this->skills->getTrainingValueDribbling());
    }

    public function testTrainWithSkill1AndBaseValue()
    {
        $this->skills->setAllTrainingValues(1);

        $this->trainer->train($this->skills);
        $this->assertEquals(2, $this->skills->getTrainingValueTackling());
        $this->assertEquals(2, $this->skills->getTrainingValuePassing());
        $this->assertEquals(2, $this->skills->getTrainingValueShooting());
        $this->assertEquals(2, $this->skills->getTrainingValueHeading());
        $this->assertEquals(2, $this->skills->getTrainingValueSpeed());
        $this->assertEquals(2, $this->skills->getTrainingValueCrossing());
        $this->assertEquals(2, $this->skills->getTrainingValueTechnics());
        $this->assertEquals(2, $this->skills->getTrainingValueIntelligence());
        $this->assertEquals(2, $this->skills->getTrainingValueSafety());
        $this->assertEquals(2, $this->skills->getTrainingValueDribbling());
    }

    public function testTrainWithSkill50()
    {
        $this->trainer->setSkill(50);

        $this->trainer->train($this->skills);
        $this->assertEquals(25, $this->skills->getTrainingValueTackling());
        $this->assertEquals(25, $this->skills->getTrainingValuePassing());
        $this->assertEquals(25, $this->skills->getTrainingValueShooting());
        $this->assertEquals(25, $this->skills->getTrainingValueHeading());
        $this->assertEquals(25, $this->skills->getTrainingValueSpeed());
        $this->assertEquals(25, $this->skills->getTrainingValueCrossing());
        $this->assertEquals(25, $this->skills->getTrainingValueTechnics());
        $this->assertEquals(25, $this->skills->getTrainingValueIntelligence());
        $this->assertEquals(25, $this->skills->getTrainingValueSafety());
        $this->assertEquals(25, $this->skills->getTrainingValueDribbling());
    }

    public function testTrainBySpecializedTrainerWithSkill100()
    {
        $this->trainer->setSkill(100);
        $this->trainer->setTrainingFactorTackling(20);
        $this->trainer->setTrainingFactorPassing(0);

        $this->trainer->train($this->skills);
        $this->assertEquals(100, $this->skills->getTrainingValueTackling());
        $this->assertEquals(0, $this->skills->getTrainingValuePassing());
        $this->assertEquals(50, $this->skills->getTrainingValueShooting());
        $this->assertEquals(50, $this->skills->getTrainingValueHeading());
        $this->assertEquals(50, $this->skills->getTrainingValueSpeed());
        $this->assertEquals(50, $this->skills->getTrainingValueCrossing());
        $this->assertEquals(50, $this->skills->getTrainingValueTechnics());
        $this->assertEquals(50, $this->skills->getTrainingValueIntelligence());
        $this->assertEquals(50, $this->skills->getTrainingValueSafety());
        $this->assertEquals(50, $this->skills->getTrainingValueDribbling());
    }
}
