<?php

namespace App\Service\Search;

use Symfony\Component\Form\FormInterface;

interface SearchQueryBuilderInterface
{
    public function rebuildQuery(FormInterface $form, $queryBuilder, $entityColumnNames);
}