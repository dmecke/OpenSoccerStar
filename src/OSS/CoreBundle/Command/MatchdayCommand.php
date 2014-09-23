<?php

namespace OSS\CoreBundle\Command;

use OSS\CoreBundle\Entity\GameDate;
use OSS\LeagueBundle\Entity\FinalPosition;
use OSS\MatchBundle\Entity\Fixture;
use OSS\MatchBundle\Entity\Team;
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
            $this->resetStandings($gameDate->getSeason() - 1);
            $this->getTransferOfferRepository()->removeAll();
            $this->getFixtureService()->createFixtures($gameDate->getSeason());
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @param int $season
     */
    private function resetStandings($season)
    {
        /** @var Team[] $teams */
        $teams = $this->getTeamRepository()->findAll();
        foreach ($teams as $team) {
            $this->resetStandingForTeam($team, $season);
        }
        $this->getEntityManager()->flush();
    }

    /**
     * @param Team $team
     * @param int $season
     *
     * @throws \Exception
     */
    private function resetStandingForTeam(Team $team, $season)
    {
        $finalPosition = new FinalPosition();
        $finalPosition->setTeam($team);
        $finalPosition->setSeason($season);
        $finalPosition->setLeague($team->getLeague());
        $finalPosition->setPosition($team->getLeague()->getPositionByTeam($team));
        $this->getEntityManager()->persist($finalPosition);
        $team->resetPointsAndGoals();
    }
}
