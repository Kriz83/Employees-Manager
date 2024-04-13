<?php

namespace App\Repository;

use App\Entity\ContractType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractType[]    findAll()
 * @method ContractType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractType::class);
    }

    public function getToListArray() 
	{			
        $active = 1;	
        $query = $this->createQueryBuilder('a')
            ->select('a.id as id, a.name as name')
            ->orderBy('a.name', 'ASC')
            ->getQuery();
            
        $contractTypes = $query->getResult();

        $contractTypesArray = [];
        
		//loop to set choices
		foreach($contractTypes as $lName) {
            
			$x =  $lName['id'];
			$c = $lName['name'];
			$contractTypesArray["$c"] = $x;			

        }

        return $contractTypesArray;

    } 

}
