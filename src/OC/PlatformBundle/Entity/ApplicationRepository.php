<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ApplicationRepository
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class ApplicationRepository extends EntityRepository
{
    /**
     * Retrieve X latest applications with their associated job offers
     * 
     * @param integer $limit
     * @return type
     */
    public function getApplicationsWithAdvert($limit)
    {
        $qb = $this->createQueryBuilder('a');

        // join with Advert entity with the alias "adv"
        $qb
            ->join('a.advert', 'adv')
            ->addSelect('adv')
        ;

        // Return result with $limit
        $qb->setMaxResults($limit);

        // Return result $qb
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
