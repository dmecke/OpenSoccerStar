<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;

class PlayerSkillsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PlayerSkills
     */
    private $playerSkills;

    public function setUp()
    {
        $this->playerSkills = new PlayerSkills();
    }

    public function tearDown()
    {
        $this->playerSkills = null;
    }

    public function testBaseValues()
    {
        $this->assertEquals(1, $this->playerSkills->getTackling());
        $this->assertEquals(1, $this->playerSkills->getPassing());
        $this->assertEquals(1, $this->playerSkills->getShooting());
        $this->assertEquals(1, $this->playerSkills->getHeading());
        $this->assertEquals(1, $this->playerSkills->getSpeed());
        $this->assertEquals(1, $this->playerSkills->getCrossing());
        $this->assertEquals(1, $this->playerSkills->getTechnics());
        $this->assertEquals(1, $this->playerSkills->getIntelligence());
        $this->assertEquals(1, $this->playerSkills->getSafety());
        $this->assertEquals(1, $this->playerSkills->getDribbling());
    }
    
    public function testSetValues()
    {
        $this->playerSkills->setTackling(10);
        $this->assertEquals(10, $this->playerSkills->getTackling());
        $this->playerSkills->setPassing(10);
        $this->assertEquals(10, $this->playerSkills->getPassing());
        $this->playerSkills->setShooting(10);
        $this->assertEquals(10, $this->playerSkills->getShooting());
        $this->playerSkills->setHeading(10);
        $this->assertEquals(10, $this->playerSkills->getHeading());
        $this->playerSkills->setSpeed(10);
        $this->assertEquals(10, $this->playerSkills->getSpeed());
        $this->playerSkills->setCrossing(10);
        $this->assertEquals(10, $this->playerSkills->getCrossing());
        $this->playerSkills->setTechnics(10);
        $this->assertEquals(10, $this->playerSkills->getTechnics());
        $this->playerSkills->setIntelligence(10);
        $this->assertEquals(10, $this->playerSkills->getIntelligence());
        $this->playerSkills->setSafety(10);
        $this->assertEquals(10, $this->playerSkills->getSafety());
        $this->playerSkills->setDribbling(10);
        $this->assertEquals(10, $this->playerSkills->getDribbling());
    }
    
    public function testSetValuesOverLimit()
    {
        $this->playerSkills->setTackling(110);
        $this->assertEquals(100, $this->playerSkills->getTackling());
        $this->playerSkills->setPassing(110);
        $this->assertEquals(100, $this->playerSkills->getPassing());
        $this->playerSkills->setShooting(110);
        $this->assertEquals(100, $this->playerSkills->getShooting());
        $this->playerSkills->setHeading(110);
        $this->assertEquals(100, $this->playerSkills->getHeading());
        $this->playerSkills->setSpeed(110);
        $this->assertEquals(100, $this->playerSkills->getSpeed());
        $this->playerSkills->setCrossing(110);
        $this->assertEquals(100, $this->playerSkills->getCrossing());
        $this->playerSkills->setTechnics(110);
        $this->assertEquals(100, $this->playerSkills->getTechnics());
        $this->playerSkills->setIntelligence(110);
        $this->assertEquals(100, $this->playerSkills->getIntelligence());
        $this->playerSkills->setSafety(110);
        $this->assertEquals(100, $this->playerSkills->getSafety());
        $this->playerSkills->setDribbling(110);
        $this->assertEquals(100, $this->playerSkills->getDribbling());
    }
    
    public function testSetValuesUnderLimit()
    {
        $this->playerSkills->setTackling(0);
        $this->assertEquals(1, $this->playerSkills->getTackling());
        $this->playerSkills->setPassing(0);
        $this->assertEquals(1, $this->playerSkills->getPassing());
        $this->playerSkills->setShooting(0);
        $this->assertEquals(1, $this->playerSkills->getShooting());
        $this->playerSkills->setHeading(0);
        $this->assertEquals(1, $this->playerSkills->getHeading());
        $this->playerSkills->setSpeed(0);
        $this->assertEquals(1, $this->playerSkills->getSpeed());
        $this->playerSkills->setCrossing(0);
        $this->assertEquals(1, $this->playerSkills->getCrossing());
        $this->playerSkills->setTechnics(0);
        $this->assertEquals(1, $this->playerSkills->getTechnics());
        $this->playerSkills->setIntelligence(0);
        $this->assertEquals(1, $this->playerSkills->getIntelligence());
        $this->playerSkills->setSafety(0);
        $this->assertEquals(1, $this->playerSkills->getSafety());
        $this->playerSkills->setDribbling(0);
        $this->assertEquals(1, $this->playerSkills->getDribbling());
    }
    
    public function testIncreaseValues()
    {
        $this->playerSkills->increaseTackling(10);
        $this->assertEquals(11, $this->playerSkills->getTackling());
        $this->playerSkills->increasePassing(10);
        $this->assertEquals(11, $this->playerSkills->getPassing());
        $this->playerSkills->increaseShooting(10);
        $this->assertEquals(11, $this->playerSkills->getShooting());
        $this->playerSkills->increaseHeading(10);
        $this->assertEquals(11, $this->playerSkills->getHeading());
        $this->playerSkills->increaseSpeed(10);
        $this->assertEquals(11, $this->playerSkills->getSpeed());
        $this->playerSkills->increaseCrossing(10);
        $this->assertEquals(11, $this->playerSkills->getCrossing());
        $this->playerSkills->increaseTechnics(10);
        $this->assertEquals(11, $this->playerSkills->getTechnics());
        $this->playerSkills->increaseIntelligence(10);
        $this->assertEquals(11, $this->playerSkills->getIntelligence());
        $this->playerSkills->increaseSafety(10);
        $this->assertEquals(11, $this->playerSkills->getSafety());
        $this->playerSkills->increaseDribbling(10);
        $this->assertEquals(11, $this->playerSkills->getDribbling());
    }
    
    public function testIncreaseValuesOverLimit()
    {
        $this->playerSkills->increaseTackling(110);
        $this->assertEquals(100, $this->playerSkills->getTackling());
        $this->playerSkills->increasePassing(110);
        $this->assertEquals(100, $this->playerSkills->getPassing());
        $this->playerSkills->increaseShooting(110);
        $this->assertEquals(100, $this->playerSkills->getShooting());
        $this->playerSkills->increaseHeading(110);
        $this->assertEquals(100, $this->playerSkills->getHeading());
        $this->playerSkills->increaseSpeed(110);
        $this->assertEquals(100, $this->playerSkills->getSpeed());
        $this->playerSkills->increaseCrossing(110);
        $this->assertEquals(100, $this->playerSkills->getCrossing());
        $this->playerSkills->increaseTechnics(110);
        $this->assertEquals(100, $this->playerSkills->getTechnics());
        $this->playerSkills->increaseIntelligence(110);
        $this->assertEquals(100, $this->playerSkills->getIntelligence());
        $this->playerSkills->increaseSafety(110);
        $this->assertEquals(100, $this->playerSkills->getSafety());
        $this->playerSkills->increaseDribbling(110);
        $this->assertEquals(100, $this->playerSkills->getDribbling());
    }
    
    public function testIncreaseValuesUnderLimit()
    {
        $this->playerSkills->increaseTackling(-1);
        $this->assertEquals(1, $this->playerSkills->getTackling());
        $this->playerSkills->increasePassing(-1);
        $this->assertEquals(1, $this->playerSkills->getPassing());
        $this->playerSkills->increaseShooting(-1);
        $this->assertEquals(1, $this->playerSkills->getShooting());
        $this->playerSkills->increaseHeading(-1);
        $this->assertEquals(1, $this->playerSkills->getHeading());
        $this->playerSkills->increaseSpeed(-1);
        $this->assertEquals(1, $this->playerSkills->getSpeed());
        $this->playerSkills->increaseCrossing(-1);
        $this->assertEquals(1, $this->playerSkills->getCrossing());
        $this->playerSkills->increaseTechnics(-1);
        $this->assertEquals(1, $this->playerSkills->getTechnics());
        $this->playerSkills->increaseIntelligence(-1);
        $this->assertEquals(1, $this->playerSkills->getIntelligence());
        $this->playerSkills->increaseSafety(-1);
        $this->assertEquals(1, $this->playerSkills->getSafety());
        $this->playerSkills->increaseDribbling(-1);
        $this->assertEquals(1, $this->playerSkills->getDribbling());
    }

    public function testDecreaseValues()
    {
        $this->playerSkills->setTackling(50);
        $this->playerSkills->decreaseTackling(10);
        $this->assertEquals(40, $this->playerSkills->getTackling());
        $this->playerSkills->setPassing(50);
        $this->playerSkills->decreasePassing(10);
        $this->assertEquals(40, $this->playerSkills->getPassing());
        $this->playerSkills->setShooting(50);
        $this->playerSkills->decreaseShooting(10);
        $this->assertEquals(40, $this->playerSkills->getShooting());
        $this->playerSkills->setHeading(50);
        $this->playerSkills->decreaseHeading(10);
        $this->assertEquals(40, $this->playerSkills->getHeading());
        $this->playerSkills->setSpeed(50);
        $this->playerSkills->decreaseSpeed(10);
        $this->assertEquals(40, $this->playerSkills->getSpeed());
        $this->playerSkills->setCrossing(50);
        $this->playerSkills->decreaseCrossing(10);
        $this->assertEquals(40, $this->playerSkills->getCrossing());
        $this->playerSkills->setTechnics(50);
        $this->playerSkills->decreaseTechnics(10);
        $this->assertEquals(40, $this->playerSkills->getTechnics());
        $this->playerSkills->setIntelligence(50);
        $this->playerSkills->decreaseIntelligence(10);
        $this->assertEquals(40, $this->playerSkills->getIntelligence());
        $this->playerSkills->setSafety(50);
        $this->playerSkills->decreaseSafety(10);
        $this->assertEquals(40, $this->playerSkills->getSafety());
        $this->playerSkills->setDribbling(50);
        $this->playerSkills->decreaseDribbling(10);
        $this->assertEquals(40, $this->playerSkills->getDribbling());
    }
    
    public function testDecreaseValuesOverLimit()
    {
        $this->playerSkills->decreaseTackling(-100);
        $this->assertEquals(100, $this->playerSkills->getTackling());
        $this->playerSkills->decreasePassing(-100);
        $this->assertEquals(100, $this->playerSkills->getPassing());
        $this->playerSkills->decreaseShooting(-100);
        $this->assertEquals(100, $this->playerSkills->getShooting());
        $this->playerSkills->decreaseHeading(-100);
        $this->assertEquals(100, $this->playerSkills->getHeading());
        $this->playerSkills->decreaseSpeed(-100);
        $this->assertEquals(100, $this->playerSkills->getSpeed());
        $this->playerSkills->decreaseCrossing(-100);
        $this->assertEquals(100, $this->playerSkills->getCrossing());
        $this->playerSkills->decreaseTechnics(-100);
        $this->assertEquals(100, $this->playerSkills->getTechnics());
        $this->playerSkills->decreaseIntelligence(-100);
        $this->assertEquals(100, $this->playerSkills->getIntelligence());
        $this->playerSkills->decreaseSafety(-100);
        $this->assertEquals(100, $this->playerSkills->getSafety());
        $this->playerSkills->decreaseDribbling(-100);
        $this->assertEquals(100, $this->playerSkills->getDribbling());
    }

    public function testDecreaseValuesUnderLimit()
    {
        $this->playerSkills->decreaseTackling(1);
        $this->assertEquals(1, $this->playerSkills->getTackling());
        $this->playerSkills->decreasePassing(1);
        $this->assertEquals(1, $this->playerSkills->getPassing());
        $this->playerSkills->decreaseShooting(1);
        $this->assertEquals(1, $this->playerSkills->getShooting());
        $this->playerSkills->decreaseHeading(1);
        $this->assertEquals(1, $this->playerSkills->getHeading());
        $this->playerSkills->decreaseSpeed(1);
        $this->assertEquals(1, $this->playerSkills->getSpeed());
        $this->playerSkills->decreaseCrossing(1);
        $this->assertEquals(1, $this->playerSkills->getCrossing());
        $this->playerSkills->decreaseTechnics(1);
        $this->assertEquals(1, $this->playerSkills->getTechnics());
        $this->playerSkills->decreaseIntelligence(1);
        $this->assertEquals(1, $this->playerSkills->getIntelligence());
        $this->playerSkills->decreaseSafety(1);
        $this->assertEquals(1, $this->playerSkills->getSafety());
        $this->playerSkills->decreaseDribbling(1);
        $this->assertEquals(1, $this->playerSkills->getDribbling());
    }
    
    public function testInitRandomValues()
    {
        $this->playerSkills->initWithRandomValues();
        $this->assertBetween(1, 100, $this->playerSkills->getTackling());
        $this->assertBetween(1, 100, $this->playerSkills->getPassing());
        $this->assertBetween(1, 100, $this->playerSkills->getShooting());
        $this->assertBetween(1, 100, $this->playerSkills->getHeading());
        $this->assertBetween(1, 100, $this->playerSkills->getSpeed());
        $this->assertBetween(1, 100, $this->playerSkills->getCrossing());
        $this->assertBetween(1, 100, $this->playerSkills->getTechnics());
        $this->assertBetween(1, 100, $this->playerSkills->getIntelligence());
        $this->assertBetween(1, 100, $this->playerSkills->getSafety());
        $this->assertBetween(1, 100, $this->playerSkills->getDribbling());
    }

    public function testSetPlayer()
    {
        $player = new Player();
        $this->playerSkills->setPlayer($player);
        $this->assertEquals($player, $this->playerSkills->getPlayer());
        $this->assertEquals($this->playerSkills, $player->getSkills());
    }

    public function testAverage()
    {
        $this->playerSkills->setAll(10);
        $this->playerSkills->setDribbling(60);
        $this->assertEquals(15, $this->playerSkills->getAverage());
    }

    public function testSetAll()
    {
        $this->playerSkills->setAll(10);
        $this->assertEquals(10, $this->playerSkills->getTackling());
        $this->assertEquals(10, $this->playerSkills->getPassing());
        $this->assertEquals(10, $this->playerSkills->getShooting());
        $this->assertEquals(10, $this->playerSkills->getHeading());
        $this->assertEquals(10, $this->playerSkills->getSpeed());
        $this->assertEquals(10, $this->playerSkills->getCrossing());
        $this->assertEquals(10, $this->playerSkills->getTechnics());
        $this->assertEquals(10, $this->playerSkills->getIntelligence());
        $this->assertEquals(10, $this->playerSkills->getSafety());
        $this->assertEquals(10, $this->playerSkills->getDribbling());
    }

    public function testSetAllTrainingValues()
    {
        $this->playerSkills->setAllTrainingValues(10);
        $this->assertEquals(10, $this->playerSkills->getTrainingValueTackling());
        $this->assertEquals(10, $this->playerSkills->getTrainingValuePassing());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueShooting());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueHeading());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueSpeed());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueCrossing());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueTechnics());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueIntelligence());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueSafety());
        $this->assertEquals(10, $this->playerSkills->getTrainingValueDribbling());
    }

    public function testCompareAverageSkill()
    {
        $this->playerSkills->setAll(50);

        $compareSkills = new PlayerSkills();
        $compareSkills->setAll(60);
        $this->assertTrue(PlayerSkills::compareAverage($this->playerSkills, $compareSkills));

        $compareSkills = new PlayerSkills();
        $compareSkills->setAll(50);
        $this->assertFalse(PlayerSkills::compareAverage($this->playerSkills, $compareSkills));

        $compareSkills = new PlayerSkills();
        $compareSkills->setAll(40);
        $this->assertFalse(PlayerSkills::compareAverage($this->playerSkills, $compareSkills));
    }

    public function testMarketValue()
    {
        $this->playerSkills->setAll(10);
        $this->assertEquals(100, $this->playerSkills->getMarketValue());

        $this->playerSkills->setAll(50);
        $this->assertEquals(1562500, $this->playerSkills->getMarketValue());

        $this->playerSkills->setAll(100);
        $this->assertEquals(100000000, $this->playerSkills->getMarketValue());
    }

    public function testGetTrainingValues()
    {
        $this->assertEquals(0, $this->playerSkills->getTrainingValueTackling());
        $this->assertEquals(0, $this->playerSkills->getTrainingValuePassing());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueShooting());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueHeading());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueSpeed());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueCrossing());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueTechnics());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueIntelligence());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueSafety());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueDribbling());
    }

    public function testSetAndGetTrainingValues()
    {
        $this->playerSkills->setTrainingValueTackling(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueTackling());
        $this->playerSkills->setTrainingValuePassing(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValuePassing());
        $this->playerSkills->setTrainingValueShooting(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueShooting());
        $this->playerSkills->setTrainingValueHeading(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueHeading());
        $this->playerSkills->setTrainingValueSpeed(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueSpeed());
        $this->playerSkills->setTrainingValueCrossing(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueCrossing());
        $this->playerSkills->setTrainingValueTechnics(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueTechnics());
        $this->playerSkills->setTrainingValueIntelligence(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueIntelligence());
        $this->playerSkills->setTrainingValueSafety(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueSafety());
        $this->playerSkills->setTrainingValueDribbling(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueDribbling());
    }

    public function testAddTrainingValues()
    {
        $this->playerSkills->addTrainingValueTackling(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueTackling());
        $this->playerSkills->addTrainingValuePassing(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValuePassing());
        $this->playerSkills->addTrainingValueShooting(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueShooting());
        $this->playerSkills->addTrainingValueHeading(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueHeading());
        $this->playerSkills->addTrainingValueSpeed(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueSpeed());
        $this->playerSkills->addTrainingValueCrossing(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueCrossing());
        $this->playerSkills->addTrainingValueTechnics(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueTechnics());
        $this->playerSkills->addTrainingValueIntelligence(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueIntelligence());
        $this->playerSkills->addTrainingValueSafety(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueSafety());
        $this->playerSkills->addTrainingValueDribbling(50);
        $this->assertEquals(50, $this->playerSkills->getTrainingValueDribbling());
    }

    public function testTrainingValueReductionLow()
    {
        $this->playerSkills->setAllTrainingValues(20);

        $this->playerSkills->decreaseTrainingValues();
        $this->assertEquals(15, $this->playerSkills->getTrainingValueTackling());
        $this->assertEquals(15, $this->playerSkills->getTrainingValuePassing());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueShooting());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueHeading());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueSpeed());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueCrossing());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueTechnics());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueIntelligence());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueSafety());
        $this->assertEquals(15, $this->playerSkills->getTrainingValueDribbling());
    }

    public function testTrainingValueAfterUpdateSkill()
    {
        $this->playerSkills->setAllTrainingValues(50);
        $this->playerSkills->updateSkills();
        $this->assertEquals(0, $this->playerSkills->getTrainingValueTackling());
        $this->assertEquals(0, $this->playerSkills->getTrainingValuePassing());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueShooting());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueHeading());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueSpeed());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueCrossing());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueTechnics());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueIntelligence());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueSafety());
        $this->assertEquals(0, $this->playerSkills->getTrainingValueDribbling());
    }

    public function testUpdateSkillUp()
    {
        $this->playerSkills->setAll(20);
        $this->playerSkills->setAllTrainingValues(100);

        $this->playerSkills->updateSkills();

        $this->assertBetween(20, 30, $this->playerSkills->getTackling());
        $this->assertBetween(20, 30, $this->playerSkills->getPassing());
        $this->assertBetween(20, 30, $this->playerSkills->getShooting());
        $this->assertBetween(20, 30, $this->playerSkills->getHeading());
        $this->assertBetween(20, 30, $this->playerSkills->getSpeed());
        $this->assertBetween(20, 30, $this->playerSkills->getCrossing());
        $this->assertBetween(20, 30, $this->playerSkills->getTechnics());
        $this->assertBetween(20, 30, $this->playerSkills->getIntelligence());
        $this->assertBetween(20, 30, $this->playerSkills->getSafety());
        $this->assertBetween(20, 30, $this->playerSkills->getDribbling());

        $this->assertBetween(0, 10, $this->playerSkills->getChangeTackling());
        $this->assertBetween(0, 10, $this->playerSkills->getChangePassing());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeShooting());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeHeading());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeSpeed());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeCrossing());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeTechnics());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeIntelligence());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeSafety());
        $this->assertBetween(0, 10, $this->playerSkills->getChangeDribbling());
    }

    public function testUpdateSkillDown()
    {
        $this->playerSkills->setAll(50);
        $this->playerSkills->setAllTrainingValues(-100);

        $this->playerSkills->updateSkills();

        $this->assertBetween(40, 50, $this->playerSkills->getTackling());
        $this->assertBetween(40, 50, $this->playerSkills->getPassing());
        $this->assertBetween(40, 50, $this->playerSkills->getShooting());
        $this->assertBetween(40, 50, $this->playerSkills->getHeading());
        $this->assertBetween(40, 50, $this->playerSkills->getSpeed());
        $this->assertBetween(40, 50, $this->playerSkills->getCrossing());
        $this->assertBetween(40, 50, $this->playerSkills->getTechnics());
        $this->assertBetween(40, 50, $this->playerSkills->getIntelligence());
        $this->assertBetween(40, 50, $this->playerSkills->getSafety());
        $this->assertBetween(40, 50, $this->playerSkills->getDribbling());

        $this->assertBetween(-10, 0, $this->playerSkills->getChangeTackling());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangePassing());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeShooting());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeHeading());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeSpeed());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeCrossing());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeTechnics());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeIntelligence());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeSafety());
        $this->assertBetween(-10, 0, $this->playerSkills->getChangeDribbling());
    }

    /**
     * @param int $min
     * @param int $max
     * @param int $value
     */
    private function assertBetween($min, $max, $value)
    {
        $this->assertGreaterThanOrEqual($min, $value);
        $this->assertLessThanOrEqual($max, $value);
    }
}
