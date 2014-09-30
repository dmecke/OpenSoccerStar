<?php

namespace OSS\CoreBundle\Command;

use OSS\CoreBundle\CoreEvents;
use OSS\CoreBundle\Entity\GameDate;
use OSS\CoreBundle\Event\GameDateEvent;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MatchdayCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('oss:matchday');
        $this->setDescription('Evaluates the current matchday');
        $this->addArgument('count', InputArgument::OPTIONAL, 'How many times shall the matchday command be executed?', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        for ($i = 1; $i <= $input->getArgument('count'); $i++) {
            $this->executeOnce();
        }
    }

    private function executeOnce()
    {
        /** @var GameDate $gameDate */
        $gameDate = $this->getGameDateRepository()->findOneBy(array());

        $this->getContainer()->get('event_dispatcher')->dispatch(CoreEvents::PRE_WEEK_CHANGE, new GameDateEvent($gameDate));
        $gameDate->incrementWeek();
        $this->getContainer()->get('event_dispatcher')->dispatch(CoreEvents::POST_WEEK_CHANGE, new GameDateEvent($gameDate));
        $this->getEntityManager()->flush();
    }
}
