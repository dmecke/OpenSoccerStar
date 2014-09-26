<?php

namespace OSS\LeagueBundle\Controller;

use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Trainer;
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

    /**
     * @param Manager $manager
     *
     * @return array
     *
     * @Route("/manager/{id}", name="profile_manager")
     * @Template
     */
    public function managerAction(Manager $manager)
    {
        return array(
            'manager' => $manager,
        );
    }

    /**
     * @param Trainer $trainer
     *
     * @return array
     *
     * @Route("/trainer/{id}", name="profile_trainer")
     * @Template
     */
    public function trainerAction(Trainer $trainer)
    {
        return array(
            'trainer' => $trainer,
        );
    }
}
