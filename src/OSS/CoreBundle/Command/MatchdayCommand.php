<?php

namespace OSS\CoreBundle\Command;

use OSS\CoreBundle\Entity\GameDate;
use OSS\MatchBundle\Entity\Match;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MatchdayCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('oss:matchday');
        $this->setDescription('Evaluates the current matchday');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var GameDate $gameDate */
        $gameDate = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:GameDate')->findOneBy(array());

        /** @var Match[] $matches */
        $matches = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('MatchBundle:Match')->findBy(array('season' => $gameDate->getSeason(), 'week' => $gameDate->getWeek()));
        $progress = new ProgressBar($output, count($matches));
        $progress->start();
        foreach ($matches as $match) {
            $this->getContainer()->get('oss.match.service.match_evaluation')->evaluateCompleteMatch($match);
            $progress->advance();
        }
        $progress->finish();

        $gameDate->incrementWeek();
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }
}
