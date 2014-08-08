<?php

namespace OSS\MatchBundle\Entity;

class Team
{
    /**
     * @var int
     */
    private $id;

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
}
