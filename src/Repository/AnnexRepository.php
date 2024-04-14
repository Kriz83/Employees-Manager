<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Annex;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annex|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annex|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annex[]    findAll()
 * @method Annex[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnexRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annex::class);
    }
}
