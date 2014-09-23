<?php

namespace OSS\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransferOfferRepository extends EntityRepository
{
    public function removeAll()
    {
        $transferOffers = $this->findAll();
        foreach ($transferOffers as $transferOffer) {
            $this->_em->remove($transferOffer);
        }
    }
}
