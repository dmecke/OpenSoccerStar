<?php

namespace OSS\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Event
{
    const TYPE_CHANCE = 'chance';
    const TYPE_GOAL = 'goal';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $team;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player;

    /**
     * @var Fixture
     *
     * @ORM\ManyToOne(targetEntity="Fixture", inversedBy="events")
     */
    private $fixture;

    private function __construct()
    {
    }

    /**
     * @param Fixture $fixture
     * @param string $type
     * @param Team $team
     * @param Player $player
     *
     * @return Event
     */
    static public function create(Fixture $fixture, $type, Team $team, Player $player)
    {
        $event = new Event();
        $event->setFixture($fixture);
        $event->setType($type);
        $event->setTeam($team);
        $event->setPlayer($player);

        return $event;
    }

    /**
     * @param Fixture $fixture
     * @param Team $team
     * @param Player $player
     *
     * @return Event
     */
    static public function createGoal(Fixture $fixture, Team $team, Player $player)
    {
        return self::create($fixture, self::TYPE_GOAL, $team, $player);
    }

    /**
     * @param Fixture $fixture
     * @param Team $team
     * @param Player $player
     *
     * @return Event
     */
    static public function createChance(Fixture $fixture, Team $team, Player $player)
    {
        return self::create($fixture, self::TYPE_CHANCE, $team, $player);
    }

    private function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isGoal()
    {
        return self::TYPE_GOAL == $this->type;
    }

    /**
     * @return bool
     */
    public function isChance()
    {
        return self::TYPE_CHANCE == $this->type;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Fixture $fixture
     */
    public function setFixture(Fixture $fixture)
    {
        $this->fixture = $fixture;
    }

    /**
     * @param Player $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }
}
