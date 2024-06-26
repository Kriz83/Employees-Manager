<?php

declare(strict_types=1);

namespace App\Service\Search;

use App\Entity\Employee;
use App\Service\Search\SearchInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Service\Search\SearchQueryBuilderInterface;

class SearchEmployeesService implements SearchInterface
{

    public function __construct(
        EntityManagerInterface $em,
        SearchQueryBuilderInterface $queryRebuilder
    ) {
        $this->em = $em;
        $this->queryRebuilder = $queryRebuilder;
    }

    public function search(FormInterface $form): array
    {
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

        $queryBuilder = $this->queryRebuilder->rebuildQuery($form, $queryBuilder, $entityFieldNames);

        if ($form['bornDateFrom']->getData()) {
            $queryBuilder
                ->andWhere('a.bornDate >= :bornDateFrom')
                ->setParameter('bornDateFrom', $form['bornDateFrom']->getData());
        }

        if ($form['bornDateTo']->getData()) {
            $queryBuilder
                ->andWhere('a.bornDate <= :bornDateTo')
                ->setParameter('bornDateTo', $form['bornDateTo']->getData());
        }
    
        $queryBuilder
            ->select('a.id as id');

        return $queryBuilder->getQuery()->getResult();
    }
}