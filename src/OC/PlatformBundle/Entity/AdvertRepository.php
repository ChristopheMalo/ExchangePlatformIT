<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
    public function getAdverts($page, $nbPerPage)
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
       
       $query
               // define the job offer from which to begin the list
               ->setFirstResult(($page-1) * $nbPerPage)
               // and the number of job offer per page
               ->setMaxResults($nbPerPage);
       
       //return $query->getResult();
       // Return PaginatorHelper object corresponding to the constructed query
       return new Paginator($query, true);
   }
}
