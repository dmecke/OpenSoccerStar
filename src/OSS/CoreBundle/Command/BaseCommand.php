<?php

namespace OSS\CoreBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Repository\TransferOfferRepository;
use OSS\CoreBundle\Services\TransferService;
use OSS\LeagueBundle\Services\FixtureService;
use OSS\MatchBundle\Repository\FixtureRepository;
use OSS\MatchBundle\Services\MatchEvaluationService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class BaseCommand extends ContainerAwareCommand
{
    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @return FixtureRepository
     */
    protected function getFixtureRepository()
    {
        return $this->getEntityManager()->getRepository('MatchBundle:Fixture');
    }

    /**
     * @return EntityRepository
     */
    protected function getGameDateRepository()
    {
        return $this->getEntityManager()->getRepository('CoreBundle:GameDate');
    }

    /**
     * @return EntityRepository
     */
    protected function getTeamRepository()
    {
        return $this->getEntityManager()->getRepository('MatchBundle:Team');
    }

    /**
     * @return TransferOfferRepository
     */
    protected function getTransferOfferRepository()
    {
        return $this->getEntityManager()->getRepository('CoreBundle:TransferOffer');
    }

    /**
     * @return FixtureService
     */
    protected function getFixtureService()
    {
        return $this->getContainer()->get('oss.league.service.fixture');
    }

    /**
     * @return MatchEvaluationService
     */
    protected function getMatchEvaluationService()
    {
        return $this->getContainer()->get('oss.match.service.match_evaluation');
    }

    /**
     * @return TransferService
     */
    protected function getTransferService()
    {
        return $this->getContainer()->get('oss.core.service.transfer');
    }
}
