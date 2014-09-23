<?php

namespace OSS\CoreBundle\Tests\Services;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\Manager;
use OSS\CoreBundle\Services\TransferService;
use OSS\MatchBundle\Entity\Player;
use OSS\MatchBundle\Entity\Team;

class TransferServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testSelectBestFittingPlayer()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $transferService = new TransferService($entityManager);

        $team = new Team();
        $team->setId(1);
        $team->setMoney(10);
        $manager = new Manager();
        $manager->setTeam($team);
        $player1 = new Player();
        $player1->setId(1);
        $player1->setTeam($team);
        $player1->setSkillDefense(10);
        $players = array($player1);

        $this->assertNull($transferService->selectBestFittingPlayer($manager, $players));

        $player2 = new Player();
        $player2->setId(2);
        $player2->setSkillDefense(10);
        $players[] = $player2;
        $this->assertEquals($player2, $transferService->selectBestFittingPlayer($manager, $players));
    }
}
