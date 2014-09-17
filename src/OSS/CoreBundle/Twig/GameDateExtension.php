<?php

namespace OSS\CoreBundle\Twig;

use Doctrine\ORM\EntityManager;
use OSS\CoreBundle\Entity\GameDate;

class GameDateExtension extends \Twig_Extension
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
     * @return array
     */
    public function getGlobals()
    {
        return array(
            'gameDate' => $this->entityManager->getRepository('CoreBundle:GameDate')->findOneBy(array()),
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'game_date';
    }
}
