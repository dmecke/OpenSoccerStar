<?php

namespace OSS\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use OSS\MatchBundle\Entity\Player;

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
        $player->setSkillDefense(rand(1, 100));
        $player->setSkillOffense(rand(1, 100));

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
