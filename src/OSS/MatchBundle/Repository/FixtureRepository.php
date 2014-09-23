<?php

namespace OSS\MatchBundle\Repository;

use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Entity\GameDate;
use OSS\MatchBundle\Entity\Fixture;

class FixtureRepository extends EntityRepository
{
    /**
     * @param GameDate $gameDate
     *
     * @return Fixture[]
     */
    public function findByGameDate(GameDate $gameDate)
    {
        return $this->findBy(array('season' => $gameDate->getSeason(), 'week' => $gameDate->getWeek()));
    }
}
