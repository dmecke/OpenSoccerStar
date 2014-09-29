<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Lineup
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $team;

    /**
     * @var Fixture
     *
     * @ORM\ManyToOne(targetEntity="Fixture", inversedBy="lineups")
     */
    private $fixture;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player1;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player2;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player3;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player4;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player5;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player6;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player7;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player8;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player9;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player10;

    /**
     * @var Player
     *
     * @ORM\ManyToOne(targetEntity="Player")
     */
    private $player11;

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
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
    public function setPlayer1(Player $player)
    {
        $this->player1 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer2(Player $player)
    {
        $this->player2 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer3(Player $player)
    {
        $this->player3 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer4(Player $player)
    {
        $this->player4 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer5(Player $player)
    {
        $this->player5 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer6(Player $player)
    {
        $this->player6 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer7(Player $player)
    {
        $this->player7 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer8(Player $player)
    {
        $this->player8 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer9(Player $player)
    {
        $this->player9 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer10(Player $player)
    {
        $this->player10 = $player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer11(Player $player)
    {
        $this->player11 = $player;
    }

    /**
     * @param int $index
     *
     * @return Player
     */
    public function getPlayer($index)
    {
        $property = 'player' . $index;

        return $this->$property;
    }

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}
