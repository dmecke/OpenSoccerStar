<?php

namespace OSS\CoreBundle\Tests\Event;

use OSS\CoreBundle\Entity\GameDate;
use OSS\CoreBundle\Event\GameDateEvent;

class GameDateEventTest extends \PHPUnit_Framework_TestCase
{
    public function testGameDateEvent()
    {
        $gameDate = new GameDate();
        $gameDateEvent = new GameDateEvent($gameDate);

        $this->assertEquals($gameDate, $gameDateEvent->getGameDate());
    }
}
