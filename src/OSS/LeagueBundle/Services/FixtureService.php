<?php

namespace OSS\LeagueBundle\Services;

use Doctrine\ORM\EntityManager;
use OSS\MatchBundle\Entity\Fixture;

class FixtureService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $season
     *
     * @throws \Exception
     */
    public function createFixtures($season)
    {
        $league = $this->entityManager->getRepository('LeagueBundle:League')->findOneBy(array());
        $numberOfTeams = count($league->getTeams());

        // cannot generate fixtures for odd number of teams
        $ghost = false;
        if (($numberOfTeams % 2) != 0) {
            $numberOfTeams++;
            $ghost = true;
        }

        $n = $numberOfTeams - 1;
        $matches = array();

        for ($currentWeek = 1; $currentWeek <= $numberOfTeams - 1; $currentWeek++) {
            $h = $numberOfTeams;
            $a = $currentWeek;
            // home or away?
            if (($currentWeek % 2) != 0) {
                $temp = $a;
                $a    = $h;
                $h    = $temp;
            }

            if (!$ghost || ($numberOfTeams != $h && $numberOfTeams != $a)) {
                $matches[] = array(
                    'home' => $h,
                    'away' => $a,
                    'week' => $currentWeek
                );
            }

            for ($k = 1; $k <= (($numberOfTeams / 2) - 1); $k++) {

                if (($currentWeek - $k) < 0) {
                    $a = $n + ($currentWeek - $k);
                } else {
                    $a = ($currentWeek - $k) % $n;
                    $a = ($a == 0) ? $n : $a; // 0 -> n-1
                }

                $h = ($currentWeek + $k) % $n;
                $h = ($h == 0) ? $n : $h;    // 0 -> n-1

                // home or away?
                if (($k % 2) == 0) {
                    $temp = $a;
                    $a = $h;
                    $h = $temp;
                }

                if (!$ghost || ($numberOfTeams != $h && $numberOfTeams != $a)) {
                    $matches[] = array(
                        'home' => $h,
                        'away' => $a,
                        'week' => $currentWeek
                    );
                }
            }
        }

        // return matches
        $matchesCount = count($matches);
        for ($x = 0; $x < $matchesCount; $x++) {
            if (!$ghost || ($numberOfTeams != $matches[$x]['away'] && $numberOfTeams != $matches[$x]['home'])) {
                $matches[] = array(
                    'home' => $matches[$x]['away'],
                    'away' => $matches[$x]['home'],
                    'week' => $matches[$x]['week'] + $n
                );
            }
        }

        $matchesCount = count($matches);

        $listOfTeams = $league->getTeams();

        for ($x = 0; $x < $matchesCount; $x++) {
            $fixture = new Fixture();
            $fixture->setSeason($season);
            $fixture->setWeek($matches[$x]['week']);
            $fixture->setTeamHome($listOfTeams[$matches[$x]['home'] - 1]);
            $fixture->setTeamAway($listOfTeams[$matches[$x]['away'] - 1]);

            $this->entityManager->persist($fixture);
        }
        $this->entityManager->flush();
    }
}
