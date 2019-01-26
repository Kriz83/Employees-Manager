<?php

namespace App\Service\Search;

use App\Entity\Contract;
use App\Service\Search\SearchInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Service\Search\SearchQueryBuilderInterface;

class SearchContractsService implements SearchInterface
{

    public function __construct(EntityManagerInterface $em, SearchQueryBuilderInterface $queryRebuilder)
    {
        $this->em = $em;
        $this->queryRebuilder = $queryRebuilder;
    }

    public function search(FormInterface $form): array
    {
        //create query builder
        $repository = $this->em->getRepository(Contract::class);

        $queryBuilder = $repository->createQueryBuilder('a');

        //get collumns names to avoid query problems when user create form field with not matching name
        $entityFieldNames = $this->em->getClassMetadata(Contract::class)->getFieldNames();

        //create query depending on filled forms
        $queryBuilder = $this->queryRebuilder->rebuildQuery($form, $queryBuilder, $entityFieldNames);
    
        $queryBuilder
            ->select('a.id as id');

        $searchedIds = $queryBuilder->getQuery()->getResult();                               

        //ids array is used to find searched data
        return $searchedIds;    
    }
}