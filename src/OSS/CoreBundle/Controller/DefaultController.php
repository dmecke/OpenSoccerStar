<?php

namespace OSS\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class DefaultController extends Controller
{
    /**
     * @return array
     *
     * @Route("/transfers", name="transfers")
     * @Template
     */
    public function transfersAction()
    {
        $gameDate = $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:GameDate')->findOneBy(array());

        return array(
            'transferOffers' => $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:TransferOffer')->findAll(),
            'transfers' => $this->get('doctrine.orm.entity_manager')->getRepository('CoreBundle:Transfer')->findBy(array('season' => $gameDate->getSeason())),
        );
    }
}
