<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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
     * Returns a list of all job offers
     * 
     * @return array
     */
    public function myFindAll()
    {
        // Method 1 : use EntityManager
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('a')
            ->from($this->_entityName, 'a')
        ;

        // Méthode 2 : use shortcut of OC\PlatformBundle\Entity\Advert -> a
        // $queryBuilder = $this->createQueryBuilder('a');

        // On n'ajoute pas de critère ou tri particulier, la construction
        // de notre requête est finie
        // Retrieve the Query from the QueryBuilder
        $query = $queryBuilder->getQuery();

        // Retrieve the result form the Query
        $results = $query->getResult();

        // Return the results
        return $results;
    }
    
    /**
     * Returns an entity advert matching the param id
     * 
     * @param integer $id
     * @return Entity Advert
     */
    public function myFindOne($id)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * Returns an entity advert matching the params author and the year
     * 
     * @param string $author
     * @param date $year
     * @return Entity Advert
     */
    public function findByAuthorAndDate($author, $year)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.author = :author')
            ->setParameter('author', $author)
            ->andWhere('a.date < :year')
            ->setParameter('year', $year)
            ->orderBy('a.date', 'DESC')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * Method to find job offers posted during the current year
     * 
     * @param \OC\PlatformBundle\Entity\QueryBuilder $qb
     */
    public function whereCurrentYear(QueryBuilder $qb)
    {
        $qb
            ->andWhere('a.date BETWEEN :start AND :end')
            ->setParameter('start', new \Datetime(date('Y') . '-01-01'))  // Date entre le 1er janvier de cette année
            ->setParameter('end', new \Datetime(date('Y') . '-12-31'))  // Et le 31 décembre de cette année
        ;
    }
    
    /**
     * Method to test whereCurrentYear
     * 
     * @return \OC\PlatformBundle\Entity\QueryBuilder $qb
     */
    public function myFind()
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.author = :author')
            ->setParameter('author', 'Marine')
        ;

        $this->whereCurrentYear($qb);

        $qb->orderBy('a.date', 'DESC');

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
    
    /** Test Doctrine Query Language (DQL) */
    /**
     * Return list of job offers (with all datas)
     * 
     * @return array
     */
    public function myFindAllDQL()
    {
        $query = $this->_em->createQuery('SELECT a FROM OCPlatformBundle:Advert a');
        $results = $query->getResult();

        return $results;
    }
    
    /** Some Methods */
    /**
     * Retrieve all the ads that match a list of categories
     * use in view: $repository->getAdvertWithCategories(array('Developer', 'Frontend developer'));
     * 
     * @param array $categoryNames
     * @return \OC\PlatformBundle\Entity\QueryBuilder $qb
     */
    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this->createQueryBuilder('a');

        // join with the entity Category with the alias "c"
        $qb
            ->join('a.categories', 'c')
            ->addSelect('c')
        ;

        // Then filtered through the names of the categories using an IN
        $qb->where($qb->expr()->in('c.name', $categoryNames));
        
        // Return the result
        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
