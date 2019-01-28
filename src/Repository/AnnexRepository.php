<?php

namespace App\Repository;

use App\Entity\Annex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Annex|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annex|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annex[]    findAll()
 * @method Annex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnexRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Annex::class);
    }

    // /**
    //  * @return Annex[] Returns an array of Annex objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annex
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
