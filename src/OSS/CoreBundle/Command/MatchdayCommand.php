<?php

namespace OSS\CoreBundle\Command;

use OSS\CoreBundle\Entity\GameDate;
use OSS\LeagueBundle\Entity\FinalPosition;
use OSS\MatchBundle\Entity\Fixture;
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

        /** @var Fixture[] $matches */
        $matches = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('MatchBundle:Fixture')->findBy(array('season' => $gameDate->getSeason(), 'week' => $gameDate->getWeek()));
        $progress = new ProgressBar($output, count($matches));
        $progress->start();
        foreach ($matches as $match) {
            $this->getContainer()->get('oss.match.service.match_evaluation')->evaluateCompleteMatch($match);
            $progress->advance();
        }
        $progress->finish();

        $this->getContainer()->get('oss.core.service.transfer')->handleTransfers();

        $gameDate->incrementWeek();
        if ($gameDate->getWeek() == 1) {
            $this->resetStandings($gameDate->getSeason() - 1);
            $this->getContainer()->get('oss.core.service.transfer')->clearTransferlist();
            $this->getContainer()->get('oss.league.service.fixture')->createFixtures($gameDate->getSeason());
        }
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }

    private function resetStandings($season)
    {
        $teams = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository('MatchBundle:Team')->findAll();
        foreach ($teams as $team) {
            $finalPosition = new FinalPosition();
            $finalPosition->setTeam($team);
            $finalPosition->setSeason($season);
            $finalPosition->setLeague($team->getLeague());
            $finalPosition->setPosition($team->getLeague()->getPositionByTeam($team));
            $this->getContainer()->get('doctrine.orm.entity_manager')->persist($finalPosition);
            $team->resetPointsAndGoals();
        }
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }
}
