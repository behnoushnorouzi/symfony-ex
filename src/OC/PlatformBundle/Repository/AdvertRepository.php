<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindAll()
    {
    // Méthode 1 : en passant par l'EntityManager
      $queryBuilder = $this->_em->createQueryBuilder();

      $queryBuilder
          ->select('a')
          ->from($this->_entityName,'a'); // Dans un repository, $this->_entityName est le namespace de l'entité gérée. Ici, il vaut donc OC\PlatformBundle\Entity\Advert

    // Méthode 2 : en passant par le raccourci (je recommande)
    //$queryBuilder2 = $this->createQueryBuilder('a');

    $query = $queryBuilder->getQuery();
    $result = $query->getResult();

    return $result;
    }

    public function getAdvertWithApplications()
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.application', 'app')
            ->addSelect('app');

            return $qb
                   ->getQuery()
                   ->getResult();
    }

    public function getAdvertByCategories($categoryNames)
    {
        $qb = $this->createQueryBuilder('a')
              ->inneJoin('a.category', 'c')
              ->addSelect('c');
       $qb->where($qb->expr()->in('c.name', $categoryNames));

       return $qb
               ->getQuery()
               ->getResult();

    }
}
