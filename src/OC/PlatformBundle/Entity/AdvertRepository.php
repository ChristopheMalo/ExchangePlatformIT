<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AdvertRepository
 *
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Alexandre Bacco
 */

class AdvertRepository extends EntityRepository
{
    /**
     * Retrieves job offers and related Entities
     * 
     * @return Adverts (Job offers)
     */
    public function getAdverts()
   {
       $query = $this->createQueryBuilder('a')
               // Join on the attribute image
               ->leftJoin('a.image', 'i')
               ->addSelect('i')
               // Join in the attribute categories
               ->leftJoin('a.categories', 'c')
               ->addSelect('c')
               ->orderBy('a.date', 'DESC')
               ->getQuery();
       
       return $query->getResult();
   }
}
