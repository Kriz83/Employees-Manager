<?php

namespace App\Service\Search;

use Symfony\Component\Form\FormInterface;
use App\Service\Search\SearchQueryBuilderInterface;

interface SearchInterface
{
    public function search(FormInterface $form): array;
}