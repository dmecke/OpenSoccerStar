<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\PlayerSkills;

class LoadPlayerData extends AbstractTeamMemberFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var int
     */
    protected $numberOfEntitiesToCreate = 20;

    /**
     * @param int $teamIndex
     *
     * @return Player
     */
    protected function createEntity($teamIndex)
    {
        $player = new Player();
        $playerSkills = new PlayerSkills();
        $playerSkills->initWithRandomValues();
        $playerSkills->setPlayer($player);

        return $player;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
