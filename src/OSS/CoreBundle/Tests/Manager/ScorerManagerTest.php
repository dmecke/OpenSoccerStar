<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Manager\ScorerManager;

class ScorerManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddAndGetByPlayer()
    {
        $scorerManager = new ScorerManager();

        $player1 = new Player();
        $player1->setId(1);

        $scorer = $scorerManager->addAndGetByPlayer($player1);
        $this->assertEquals($player1, $scorer->getPlayer());

        $player2 = new Player();
        $player2->setId(2);

        $scorer = $scorerManager->addAndGetByPlayer($player2);
        $this->assertEquals($player2, $scorer->getPlayer());

        $scorer = $scorerManager->addAndGetByPlayer($player1);
        $this->assertEquals($player1, $scorer->getPlayer());
    }
}
