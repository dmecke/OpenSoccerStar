<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\GameDate;

class GameDateTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultValues()
    {
        $gameDate = new GameDate();

        $this->assertEquals(1, $gameDate->getSeason());
        $this->assertEquals(1, $gameDate->getWeek());
    }

    public function testBasicIncrementWeek()
    {
        $gameDate = new GameDate();
        $gameDate->incrementWeek();

        $this->assertEquals(1, $gameDate->getSeason());
        $this->assertEquals(2, $gameDate->getWeek());
    }

    public function testBasicAddWeeks()
    {
        $gameDate = new GameDate();
        $gameDate->addWeeks(1);

        $this->assertEquals(1, $gameDate->getSeason());
        $this->assertEquals(2, $gameDate->getWeek());
    }

    public function testAddWeeksWithSeasonChange()
    {
        $gameDate = new GameDate();

        $gameDate->addWeeks(34);
        $this->assertEquals(2, $gameDate->getSeason());
        $this->assertEquals(1, $gameDate->getWeek());
    }

    public function testAddWeeksWithMultipleSeasonChange()
    {
        $gameDate = new GameDate();

        $gameDate->addWeeks(68);
        $this->assertEquals(3, $gameDate->getSeason());
        $this->assertEquals(1, $gameDate->getWeek());
    }
}
