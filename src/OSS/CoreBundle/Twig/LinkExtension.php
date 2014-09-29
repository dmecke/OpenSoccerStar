<?php

namespace OSS\CoreBundle\Twig;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;
use Symfony\Component\Routing\Router;

class LinkExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return \Twig_SimpleFilter
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('playerLink', array($this, 'playerLinkFilter'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('teamLink', array($this, 'teamLinkFilter'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @param Player $player
     *
     * @return string
     */
    public function playerLinkFilter(Player $player)
    {
        return '<a href="' . $this->router->generate('profile_player', array('id' => $player->getId())) . '">' . $player->getName() . '</a>';
    }

    /**
     * @param Team $team
     *
     * @return string
     */
    public function teamLinkFilter(Team $team)
    {
        return '<a href="' . $this->router->generate('profile_team', array('id' => $team->getId())) . '">' . $team->getName() . '</a>';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'oss.core.link';
    }
}
