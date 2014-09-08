<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\GameDate;

class GameDateTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultValues()
    {
        $gameDate = new GameDate();
        $this->assertEqualsGameDate(1, 1, $gameDate);
    }

    public function testBasicIncrementWeek()
    {
        $gameDate = new GameDate();
        $gameDate->incrementWeek();
        $this->assertEqualsGameDate(1, 2, $gameDate);
    }

    public function testBasicAddWeeks()
    {
        $gameDate = new GameDate();
        $gameDate->addWeeks(1);
        $this->assertEqualsGameDate(1, 2, $gameDate);
    }

    public function testAddWeeksWithSeasonChange()
    {
        $gameDate = new GameDate();
        $gameDate->addWeeks(34);
        $this->assertEqualsGameDate(2, 1, $gameDate);
    }

    public function testAddWeeksWithMultipleSeasonChange()
    {
        $gameDate = new GameDate();
        $gameDate->addWeeks(68);
        $this->assertEqualsGameDate(3, 1, $gameDate);
    }

    /**
     * @param int $season
     * @param int $week
     * @param GameDate $gameDate
     */
    private function assertEqualsGameDate($season, $week, GameDate $gameDate)
    {
        $this->assertEquals($season, $gameDate->getSeason());
        $this->assertEquals($week, $gameDate->getWeek());
    }
}
