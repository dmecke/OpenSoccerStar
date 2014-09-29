<?php

namespace OSS\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Team
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var League
     *
     * @ORM\ManyToOne(targetEntity="League", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $points = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsFor = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $goalsAgainst = 0;

    /**
     * @var Player[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Player", mappedBy="team")
     */
    private $players;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $money;

    /**
     * @var Trainer
     *
     * @ORM\OneToOne(targetEntity="Trainer", mappedBy="team")
     */
    private $trainer;

    /**
     * @var Manager
     *
     * @ORM\OneToOne(targetEntity="Manager", mappedBy="team")
     */
    private $manager;

    /**
     * @var FinalPosition[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FinalPosition", mappedBy="team", cascade={"all"})
     */
    private $finalPositions;

    /**
     * @var Transfer[]
     *
     * @ORM\OneToMany(targetEntity="Transfer", mappedBy="targetTeam")
     */
    private $transfersIncoming;

    /**
     * @var Transfer[]
     *
     * @ORM\OneToMany(targetEntity="Transfer", mappedBy="originTeam")
     */
    private $transfersOutgoing;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->finalPositions = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Team $team
     *
     * @return bool
     */
    public function equals(Team $team)
    {
        return $this->getId() == $team->getId();
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function addPoints($points)
    {
        $this->points += $points;
    }

    /**
     * @param int $goalsFor
     */
    public function setGoalsFor($goalsFor)
    {
        $this->goalsFor = $goalsFor;
    }

    /**
     * @param int $goalsFor
     */
    public function addGoalsFor($goalsFor)
    {
        $this->goalsFor += $goalsFor;
    }

    /**
     * @return int
     */
    public function getGoalsDifference()
    {
        return $this->goalsFor - $this->goalsAgainst;
    }

    /**
     * @param int $goalsAgainst
     */
    public function setGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst = $goalsAgainst;
    }

    /**
     * @param int $goalsAgainst
     */
    public function addGoalsAgainst($goalsAgainst)
    {
        $this->goalsAgainst += $goalsAgainst;
    }

    /**
     * @return int
     */
    public function getGoalsFor()
    {
        return $this->goalsFor;
    }

    /**
     * @return int
     */
    public function getGoalsAgainst()
    {
        return $this->goalsAgainst;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param League $league
     */
    public function setLeague(League $league)
    {
        $this->league = $league;
    }

    /**
     * @return ArrayCollection|Player[]
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setTeam($this);
        }
    }

    /**
     * @return Player
     *
     * @throws \Exception
     */
    public function getRandomPlayer()
    {
        if (0 == count($this->players)) {
            throw new \Exception('this team has no players');
        }

        return $this->players[rand(0, count($this->players) - 1)];
    }

    /**
     * @return Player
     *
     * @throws \Exception
     */
    public function getRandomPlayerFromLineup()
    {
        $lineup = $this->getLineup();

        if (0 == count($lineup)) {
            throw new \Exception('no players in the lineup');
        }

        return $lineup[rand(0, count($lineup) - 1)];
    }

    /**
     * @return Player[]
     */
    public function getLineup()
    {
        $players = $this->players->toArray();
        usort($players, array('OSS\CoreBundle\Entity\Player', 'compareAverageSkill'));

        return array_slice($players, 0, 11);
    }

    public function resetPointsAndGoals()
    {
        $this->points = 0;
        $this->goalsFor = 0;
        $this->goalsAgainst = 0;
    }

    /**
     * @return League
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * @return FinalPosition[]
     */
    public function getFinalPositions()
    {
        return $this->finalPositions;
    }

    /**
     * @return int
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @param int $money
     */
    public function setMoney($money)
    {
        $this->money = $money;
    }

    /**
     * @param int $amount
     */
    public function addMoney($amount)
    {
        $this->money += $amount;
    }

    /**
     * @param int $amount
     */
    public function subtractAmount($amount)
    {
        $this->money -= $amount;
    }

    /**
     * @return Trainer
     */
    public function getTrainer()
    {
        return $this->trainer;
    }

    /**
     * @param Trainer $trainer
     */
    public function setTrainer(Trainer $trainer)
    {
        $this->trainer = $trainer;
        if (null === $trainer->getTeam()) {
            $trainer->setTeam($this);
        }
    }

    /**
     * @return bool
     */
    public function hasTrainer()
    {
        return null !== $this->trainer;
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param Manager $manager
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;
        if (null === $manager->getTeam()) {
            $manager->setTeam($this);
        }
    }

    /**
     * @return bool
     */
    public function hasManager()
    {
        return null !== $this->manager;
    }

    /**
     * @param int $season
     *
     * @throws \Exception
     */
    public function createFinalPosition($season)
    {
        $finalPosition = new FinalPosition();
        $finalPosition->setTeam($this);
        $finalPosition->setSeason($season);
        $finalPosition->setLeague($this->league);
        $finalPosition->setPosition($this->league->getPositionByTeam($this));
        $this->finalPositions->add($finalPosition);
    }

    /**
     * @return Transfer[]
     */
    public function getTransfersIncoming()
    {
        return $this->transfersIncoming;
    }

    /**
     * @return Transfer[]
     */
    public function getTransfersOutgoing()
    {
        return $this->transfersOutgoing;
    }

    public function train()
    {
        if (!$this->hasTrainer()) {
            return;
        }

        foreach ($this->players as $player)
        {
            $this->trainer->train($player);
        }
    }
}
