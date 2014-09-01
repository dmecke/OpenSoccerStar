<?php

namespace OSS\LeagueBundle\Controller;

use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    /**
     * @param Team $team
     *
     * @return array
     *
     * @Route("/team/{id}", name="profile_team")
     * @Template
     */
    public function teamAction(Team $team)
    {
        return array(
            'team' => $team,
        );
    }

    /**
     * @param Player $player
     *
     * @return array
     *
     * @Route("/player/{id}", name="profile_player")
     * @Template
     */
    public function playerAction(Player $player)
    {
        return array(
            'player' => $player,
        );
    }
}
