<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Scorer;

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
