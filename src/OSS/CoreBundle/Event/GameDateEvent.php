<?php

namespace OSS\CoreBundle\Event;

use OSS\CoreBundle\Entity\GameDate;
use Symfony\Component\EventDispatcher\Event;

class GameDateEvent extends Event
{
    /**
     * @var GameDate
     */
    private $gameDate;

    /**
     * @param GameDate $gameDate
     */
    public function __construct(GameDate $gameDate)
    {
        $this->gameDate = $gameDate;
    }

    /**
     * @return GameDate
     */
    public function getGameDate()
    {
        return $this->gameDate;
    }
}
