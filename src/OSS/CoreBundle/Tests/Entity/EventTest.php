<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Event;
use OSS\CoreBundle\Entity\Fixture;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testGoal()
    {
        $event = Event::createGoal(new Fixture(), new Team(), new Player(), 1);
        $this->assertTrue($event->isGoal());
    }

    public function testChance()
    {
        $event = Event::createChance(new Fixture(), new Team(), new Player(), 1);
        $this->assertTrue($event->isChance());
    }
}
