<?php

namespace OSS\MatchBundle\Tests\Entity;

use OSS\MatchBundle\Entity\Team;

class TeamTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $team1 = new Team();
        $team2 = new Team();

        $this->assertTrue($team1->equals($team2));

        $team1->setId(1);
        $team2->setId(2);
        $this->assertFalse($team1->equals($team2));
    }
}
