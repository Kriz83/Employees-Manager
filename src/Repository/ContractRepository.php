<?php

namespace App\Repository;

use App\Entity\Contract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contract|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contract|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contract[]    findAll()
 * @method Contract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contract::class);
    }

    public function findByEmployee($employee)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.employee = :employee')
            ->setParameter('employee', $employee)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
        
    public function getContractsByIdsArray($IdsArray) 
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.id IN (:IdsArray)')
            ->setParameter('IdsArray', $IdsArray)
            ->orderBy('p.id', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function getMaxStartDate() 
    {
        $query = $this->createQueryBuilder('p')
            ->select('max(p.startDate) as maxStartDate')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getMinStartDate() 
    {
        $query = $this->createQueryBuilder('p')
            ->select('min(p.startDate) as minStartDate')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getMaxStopDate() 
    {
        $query = $this->createQueryBuilder('p')
            ->select('max(p.stopDate) as maxStopDate')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getMinStopDate() 
    {
        $query = $this->createQueryBuilder('p')
            ->select('min(p.stopDate) as minStopDate')
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findOneActiveByEmployeeId($employeeId)
    {
        $active = true;

        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.employee = :employeeId')
            ->setParameter('employeeId', $employeeId)
            ->andWhere('p.active = :active')
            ->setParameter('active', $active)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    public function getContractsInDatesRangeAndEmployeeId($startDateRange, $stopDateRange, $contractId, $employeeId)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->andWhere('p.employee = :employeeId')
            ->setParameter('employeeId', $employeeId)
            ->andWhere('p.id != :contractId')
            ->setParameter('contractId', $contractId)
            ->andWhere('
                (p.startDate >= :startDateRange AND p.startDate <= :stopDateRange) OR
                (p.stopDate >= :startDateRange AND p.stopDate <= :stopDateRange) OR
                (p.startDate <= :startDateRange AND p.stopDate >= :stopDateRange)
            ')
            ->setParameter('startDateRange', $startDateRange)
            ->setParameter('stopDateRange', $stopDateRange)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }
}
