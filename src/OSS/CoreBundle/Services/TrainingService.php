<?php

namespace OSS\CoreBundle\Services;

use OSS\CoreBundle\Entity\Player;
use OSS\CoreBundle\Entity\Trainer;

class TrainingService
{
    public function train(Player $player, Trainer $trainer)
    {
        $defensive = ceil($trainer->getSkill() * $trainer->getTrainingFactorDefensive());
        $offensive = ceil($trainer->getSkill() * $trainer->getTrainingFactorOffensive());

        $player->addTrainingValueDefense($defensive);
        $player->addTrainingValueOffense($offensive);
    }
}
