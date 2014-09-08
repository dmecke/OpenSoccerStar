<?php

namespace OSS\LeagueBundle\Tests\FixtureGenerator;

use OSS\LeagueBundle\FixtureGenerator\Generator;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testToggleTeams()
    {
        $generator = new Generator(2);
        $generator->setCurrentHomeTeam(1);
        $generator->setCurrentAwayTeam(2);
        $generator->toggleHomeAndAwayTeam();

        $this->assertEquals(2, $generator->getCurrentHomeTeam());
        $this->assertEquals(1, $generator->getCurrentAwayTeam());
    }

    public function testGeneratedFixtures()
    {
        $generator = new Generator(2);
        $fixtures = $generator->createFixtures();

        $this->assertEquals(1, $fixtures[0]->getTeamHome());
        $this->assertEquals(2, $fixtures[0]->getTeamAway());

        $this->assertEquals(2, $fixtures[1]->getTeamHome());
        $this->assertEquals(1, $fixtures[1]->getTeamAway());
    }

    public function testGeneratedFixturesWithGhost()
    {
        $generator = new Generator(3);
        $fixtures = $generator->createFixtures();

        $this->assertEquals(2, $fixtures[0]->getTeamHome());
        $this->assertEquals(3, $fixtures[0]->getTeamAway());

        $this->assertEquals(3, $fixtures[1]->getTeamHome());
        $this->assertEquals(1, $fixtures[1]->getTeamAway());

        $this->assertEquals(1, $fixtures[2]->getTeamHome());
        $this->assertEquals(2, $fixtures[2]->getTeamAway());

        $this->assertEquals(3, $fixtures[3]->getTeamHome());
        $this->assertEquals(2, $fixtures[3]->getTeamAway());

        $this->assertEquals(1, $fixtures[4]->getTeamHome());
        $this->assertEquals(3, $fixtures[4]->getTeamAway());

        $this->assertEquals(2, $fixtures[5]->getTeamHome());
        $this->assertEquals(1, $fixtures[5]->getTeamAway());
    }

    public function testWrapTeam()
    {
        $generator = new Generator(2);
        $this->assertEquals(2, $generator->wrapTeam(2));
        $this->assertEquals(1, $generator->wrapTeam(1));
        $this->assertEquals(1, $generator->wrapTeam(0));

        $generator = new Generator(3);
        $this->assertEquals(3, $generator->wrapTeam(3));
        $this->assertEquals(2, $generator->wrapTeam(2));
        $this->assertEquals(1, $generator->wrapTeam(1));
        $this->assertEquals(3, $generator->wrapTeam(0)); // 3 as we have a ghost team

        $generator = new Generator(4);
        $this->assertEquals(4, $generator->wrapTeam(4));
        $this->assertEquals(3, $generator->wrapTeam(3));
        $this->assertEquals(2, $generator->wrapTeam(2));
        $this->assertEquals(1, $generator->wrapTeam(1));
        $this->assertEquals(3, $generator->wrapTeam(0));
    }
}
