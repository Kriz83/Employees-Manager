<?php

namespace App\Repository;

use App\Entity\Factory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Factory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factory[]    findAll()
 * @method Factory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factory::class);
    }

    public function getToListArray()
    {
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name')
            ->orderBy('a.name', 'ASC')
            ->getQuery();

        $factories = $query->getResult();

        $factoriesArray = [];

        foreach ($factories as $lName) {
            $x = $lName['id'];
            $c = $lName['name'];
            $factoriesArray["$c"] = $x;
        }

        return $factoriesArray;
    }
}
