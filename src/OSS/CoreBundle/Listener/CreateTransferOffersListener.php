<?php

namespace OSS\CoreBundle\Listener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Entity\Player;

class CreateTransferOffersListener
{
    /**
     * @var EntityRepository
     */
    private $playerRepository;

    /**
     * @var EntityRepository
     */
    private $managerRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityRepository $playerRepository
     * @param EntityRepository $managerRepository
     * @param EntityManager $entityManager
     */
    public function __construct(EntityRepository $playerRepository, EntityRepository $managerRepository, EntityManager $entityManager)
    {
        $this->playerRepository = $playerRepository;
        $this->managerRepository = $managerRepository;
        $this->entityManager = $entityManager;
    }

    public function execute()
    {
        foreach ($this->findAllManagers() as $manager) {
            $pickedPlayer = $manager->selectBestFittingPlayer($this->pickPlayersToInvestigate($this->findAllPlayers()));
            if ($pickedPlayer !== null) {
                $transferOffer = $manager->createTransferOffer($pickedPlayer, $manager);
                $this->entityManager->persist($transferOffer);
            }
        }
    }

    /**
     * @return Player[]
     */
    private function findAllPlayers()
    {
        return $this->playerRepository->findAll();
    }

    /**
     * @return Manager[]
     */
    private function findAllManagers()
    {
        return $this->managerRepository->findAll();
    }

    /**
     * @param Player[] $players
     *
     * @return Player[]
     */
    private function pickPlayersToInvestigate(array $players)
    {
        $playersToInvestiage = array();
        for ($i = 0; $i < 10; $i++) {
            $playersToInvestiage[] = $players[rand(0, count($players) - 1)];
        }

        return $playersToInvestiage;
    }
}
