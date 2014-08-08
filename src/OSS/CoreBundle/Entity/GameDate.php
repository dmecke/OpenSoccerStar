<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class GameDate
{
    const WEEKS_PER_SEASON = 34;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $week = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $season = 1;

    /**
     * @return int
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @return int
     */
    public function getWeek()
    {
        return $this->week;
    }

    public function incrementWeek()
    {
        $this->addWeeks(1);
    }

    /**
     * @param int $weeks
     */
    public function addWeeks($weeks)
    {
        $this->week += $weeks;
        $this->purge();
    }

    private function purge()
    {
        while ($this->week > self::WEEKS_PER_SEASON) {
            $this->season++;
            $this->week -= self::WEEKS_PER_SEASON;
        }
    }
}
