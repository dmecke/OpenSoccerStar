<?php

namespace OSS\MatchBundle\Controller;

use OSS\MatchBundle\Entity\Fixture;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @param Fixture $fixture
     *
     * @return array
     *
     * @Route("/fixture/{id}", name="fixture")
     * @Template
     */
    public function fixtureAction(Fixture $fixture)
    {
        return array(
            'fixture' => $fixture,
        );
    }
}
