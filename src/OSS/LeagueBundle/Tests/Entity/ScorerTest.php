<?php

namespace OSS\LeagueBundle\Tests\Entity;

use OSS\LeagueBundle\Entity\Scorer;

class ScorerTest extends \PHPUnit_Framework_TestCase
{
    public function testIncrementGoals()
    {
        $scorer = new Scorer();
        $this->assertEquals(0, $scorer->getGoals());

        $scorer->incrementGoals();
        $this->assertEquals(1, $scorer->getGoals());
    }
}
