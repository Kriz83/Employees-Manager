<?php

namespace App\Service\Search;

use App\Entity\Employee;
use App\Service\Search\SearchInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Service\Search\SearchQueryBuilderInterface;

class SearchEmployeesService implements SearchInterface
{

    public function __construct(EntityManagerInterface $em, SearchQueryBuilderInterface $queryRebuilder)
    {
        $this->em = $em;
        $this->queryRebuilder = $queryRebuilder;
    }

    public function search(FormInterface $form): array
    {
        //create query builder
        $repository = $this->em->getRepository(Employee::class);

        $queryBuilder = $repository->createQueryBuilder('a');

        /*
            Get collumns names to avoid query problems when user create form field with not matching name.
            Fields with assosiation must be loaded by diffrent method so two arrays must be merged
        */
        $entityFieldNames = array_merge(
            $this->em->getClassMetadata(Employee::class)->getFieldNames(),
            array_keys($this->em->getClassMetadata(Employee::class)->getAssociationMappings())
        );

        //create query depending on filled forms
        $queryBuilder = $this->queryRebuilder->rebuildQuery($form, $queryBuilder, $entityFieldNames);
    
        $queryBuilder
            ->select('a.id as id');

        $searchedIds = $queryBuilder->getQuery()->getResult();                               

        //ids array is used to find searched employees

        return $searchedIds;
    }
}