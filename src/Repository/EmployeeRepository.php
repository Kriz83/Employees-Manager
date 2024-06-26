<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function findByDocumentNumber($documentNumber)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.idDocumentNumber = :documentNumber')
            ->setParameter('documentNumber', $documentNumber)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function checkIfExistByDocumentNumber($documentNumber)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.idDocumentNumber = :documentNumber')
            ->setParameter('documentNumber', $documentNumber)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getEmployeesByIdsArray(array $idsArray)
    {
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.surname', 'ASC')
            ->where('p.id IN (:idsArray)')
            ->setParameter('idsArray', $idsArray)
            ->getQuery();

        return $query->getResult();
    }

    public function getMaxBornDate()
    {
        $query = $this->createQueryBuilder('p')
            ->select('max(p.bornDate) as maxBornDate')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getMinBornDate()
    {
        $query = $this->createQueryBuilder('p')
            ->select('min(p.bornDate) as minBornDate')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
