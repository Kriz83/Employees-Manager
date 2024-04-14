<?php

declare(strict_types=1);

namespace App\Service\Search;

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormInterface;

interface SearchQueryBuilderInterface
{
    public function rebuildQuery(
        FormInterface $form,
        QueryBuilder $queryBuilder,
        $entityColumnNames
    ): QueryBuilder;
}