<?php

namespace OSS\CoreBundle\Command;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use OSS\CoreBundle\Repository\FixtureRepository;
use OSS\CoreBundle\Repository\TransferOfferRepository;
use OSS\CoreBundle\Services\FixtureService;
use OSS\CoreBundle\Services\MatchEvaluationService;
use OSS\CoreBundle\Services\TrainingService;
use OSS\CoreBundle\Services\TransferService;
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
        return $this->getEntityManager()->getRepository('CoreBundle:Fixture');
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
    protected function getLeagueRepository()
    {
        return $this->getEntityManager()->getRepository('CoreBundle:League');
    }

    /**
     * @return EntityRepository
     */
    protected function getTeamRepository()
    {
        return $this->getEntityManager()->getRepository('CoreBundle:Team');
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
        return $this->getContainer()->get('oss.core.service.fixture');
    }

    /**
     * @return MatchEvaluationService
     */
    protected function getMatchEvaluationService()
    {
        return $this->getContainer()->get('oss.core.service.match_evaluation');
    }

    /**
     * @return TrainingService
     */
    protected function getTrainingService()
    {
        return $this->getContainer()->get('oss.core.service.training');
    }

    /**
     * @return TransferService
     */
    protected function getTransferService()
    {
        return $this->getContainer()->get('oss.core.service.transfer');
    }
}
