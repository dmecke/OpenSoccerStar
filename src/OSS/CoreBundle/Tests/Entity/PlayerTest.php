<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;
use OSS\CoreBundle\Entity\Team;

class PlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Player
     */
    private $player;

    public function setUp()
    {
        $this->player = new Player();
    }

    public function tearDown()
    {
        $this->player = null;
    }

    public function testEquals()
    {
        $player2 = new Player();

        $this->assertTrue($this->player->equals($player2));

        $this->player->setId(1);
        $player2->setId(1);
        $this->assertTrue($this->player->equals($player2));

        $this->player->setId(1);
        $player2->setId(2);
        $this->assertFalse($this->player->equals($player2));
    }

    public function testSetTeam()
    {
        $team = new Team();

        $this->player->setTeam($team);
        $this->assertEquals($team, $this->player->getTeam());
        $this->assertContains($this->player, $team->getPlayers());
    }

    public function testSetPlayerSkills()
    {
        $playerSkills = new PlayerSkills();
        $this->player->setSkills($playerSkills);
        $this->assertEquals($playerSkills, $this->player->getSkills());
        $this->assertEquals($this->player, $playerSkills->getPlayer());
    }
}
