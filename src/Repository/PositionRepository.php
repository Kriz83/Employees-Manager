<?php

namespace App\Repository;

use App\Entity\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Position::class);
    }

    public function getToListArray() 
	{			
        $active = 1;	
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name')
            ->orderBy('a.name', 'ASC')
            ->getQuery();
            
        $positions = $query->getResult();

        $positionsArray = [];
        
		//loop to set choices
		foreach($positions as $lName) {
            
			$x =  $lName['id'];
			$c = $lName['name'];
			$positionsArray["$c"] = $x;			

        }

        return $positionsArray;

    } 
    
}
