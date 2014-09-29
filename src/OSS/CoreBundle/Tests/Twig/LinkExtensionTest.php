<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;
use OSS\CoreBundle\Twig\LinkExtension;
use Symfony\Component\Routing\Router;

class LinkExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LinkExtension
     */
    private $linkExtension;

    public function setUp()
    {
        /** @var Router $router */
        $router = $this->getMockBuilder('Symfony\Component\Routing\Router')->disableOriginalConstructor()->setMethods(array('generate'))->getMock();
        $router->expects($this->any())->method('generate')->will($this->returnValue('generated_link'));
        $this->linkExtension = new LinkExtension($router);
    }

    public function tearDown()
    {
        $this->linkExtension = null;
    }

    public function testPlayerLinkFilter()
    {
        $player = new Player();
        $player->setId(1);
        $player->setName('Daniel Mecke');
        $this->assertEquals('<a href="generated_link">Daniel Mecke</a>', $this->linkExtension->playerLinkFilter($player));
    }

    public function testTeamLinkFilter()
    {
        $team = new Team();
        $team->setId(1);
        $team->setName('Team A');
        $this->assertEquals('<a href="generated_link">Team A</a>', $this->linkExtension->teamLinkFilter($team));
    }
}
