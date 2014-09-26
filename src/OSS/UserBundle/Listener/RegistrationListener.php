<?php

namespace OSS\UserBundle\Listener;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\UserEvent;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Team;
use OSS\UserBundle\Entity\User;

class RegistrationListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserEvent $event
     */
    public function onRegister(UserEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();

        $player = new Player();
        $player->setName($user->getUsername());
        $player->setSkillDefense(rand(1, 100));
        $player->setSkillOffense(rand(1, 100));
        /** @var Team[] $teams */
        $teams = $this->entityManager->getRepository('CoreBundle:Team')->findAll();
        $player->setTeam($teams[rand(0, count($teams) - 1)]);
        $this->entityManager->persist($player);

        $user->setPlayer($player);

        $this->entityManager->flush();
    }
}
