<?php

namespace OSS\MatchBundle\Tests\Entity;

use OSS\MatchBundle\Entity\Event;
use OSS\MatchBundle\Entity\Fixture;
use OSS\MatchBundle\Entity\Team;

class EventTest extends \PHPUnit_Framework_TestCase
{
    public function testGoal()
    {
        $event = Event::createGoal(new Fixture(), new Team());
        $this->assertTrue($event->isGoal());
    }

    public function testChance()
    {
        $event = Event::createChance(new Fixture(), new Team());
        $this->assertTrue($event->isChance());
    }
}
