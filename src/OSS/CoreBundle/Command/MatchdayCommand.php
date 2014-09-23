<?php

namespace OSS\CoreBundle\Command;

use OSS\CoreBundle\Entity\GameDate;
use OSS\LeagueBundle\Entity\League;
use OSS\MatchBundle\Entity\Fixture;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MatchdayCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('oss:matchday');
        $this->setDescription('Evaluates the current matchday');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var GameDate $gameDate */
        $gameDate = $this->getGameDateRepository()->findOneBy(array());

        /** @var Fixture[] $matches */
        $matches = $this->getFixtureRepository()->findByGameDate($gameDate);
        $progress = new ProgressBar($output, count($matches));
        $progress->start();
        foreach ($matches as $match) {
            $this->getMatchEvaluationService()->evaluateCompleteMatch($match);
            $progress->advance();
        }
        $progress->finish();

        $this->getTransferService()->handleTransfers();

        $gameDate->incrementWeek();
        if ($gameDate->getWeek() == 1) {
            /** @var League[] $leagues */
            $leagues = $this->getLeagueRepository()->findAll();
            foreach ($leagues as $league) {
                $league->createFinalPositions($gameDate->getSeason() - 1);
                $league->resetStandings();
            }
            $this->getTransferOfferRepository()->removeAll();
            $this->getFixtureService()->createFixtures($gameDate->getSeason());
        }
        $this->getEntityManager()->flush();
    }
}
