<?php

declare(strict_types=1);

namespace App\Service\Search;

use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class SearchContractsService implements SearchInterface
{

    public function __construct(
        EntityManagerInterface $em,
        SearchQueryBuilderInterface $queryBuilder
    ) {
        $this->em = $em;
        $this->queryBuilder = $queryBuilder;
    }

    public function search(FormInterface $form): array
    {
        $repository = $this->em->getRepository(Contract::class);

        $queryBuilder = $repository->createQueryBuilder('a');

        /*
            Get collumns names to avoid query problems when user create form field with not matching name.
            Fields with assosiation must be loaded by diffrent method so two arrays must be merged
        */
        $entityFieldNames = array_merge(
            $this->em->getClassMetadata(Contract::class)->getFieldNames(),
            array_keys($this->em->getClassMetadata(Contract::class)->getAssociationMappings())
        );

        $queryBuilder = $this->queryBuilder->rebuildQuery($form, $queryBuilder, $entityFieldNames);

        if ($form['startDateFrom']->getData()) {
            $queryBuilder
                ->andWhere('a.startDate >= :startDateFrom')
                ->setParameter('startDateFrom', $form['startDateFrom']->getData());
        }

        if ($form['startDateTo']->getData()) {
            $queryBuilder
                ->andWhere('a.startDate <= :startDateTo')
                ->setParameter('startDateTo', $form['startDateTo']->getData());
        }
    
        $queryBuilder
            ->select('a.id as id');

        return $queryBuilder->getQuery()->getResult();
    }
}