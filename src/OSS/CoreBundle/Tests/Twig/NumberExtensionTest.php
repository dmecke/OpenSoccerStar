<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Twig\NumberExtension;

class NumberExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NumberExtension
     */
    private $numberExtension;

    public function setUp()
    {
        $this->numberExtension = new NumberExtension();
    }

    public function tearDown()
    {
        $this->numberExtension = null;
    }

    public function testMoneyFilter()
    {
        $this->assertEquals('0$', $this->numberExtension->moneyFilter(0));
        $this->assertEquals('100$', $this->numberExtension->moneyFilter(100));
        $this->assertEquals('1.000$', $this->numberExtension->moneyFilter(1000));
    }

    public function testSignedFilter()
    {
        $this->assertEquals('0', $this->numberExtension->signedFilter(0));
        $this->assertEquals('+1', $this->numberExtension->signedFilter(1));
        $this->assertEquals('-1', $this->numberExtension->signedFilter(-1));
    }

    public function testSignedCssClassFilter()
    {
        $this->assertEquals('', $this->numberExtension->cssClassFilter(0));
        $this->assertEquals('plus', $this->numberExtension->cssClassFilter(1));
        $this->assertEquals('minus', $this->numberExtension->cssClassFilter(-1));
    }
}
