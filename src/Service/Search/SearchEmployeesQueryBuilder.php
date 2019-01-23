<?php

namespace App\Service\Search;

use Symfony\Component\Form\FormInterface;
use App\Service\Search\SearchQueryBuilderInterface;

class SearchEmployeesQueryBuilder implements SearchQueryBuilderInterface
{

    public function rebuildQuery(FormInterface $form, $queryBuilder)
    {
        $formData = $form->getData();

        //add queries to main query depend on filled form fields
        foreach ($formData as $key => $value) {
            if ($key != '') {
                $queryBuilder
                    ->andWhere('a.'.$key.' LIKE :'.$key.'')
                    ->setParameter(''.$key.'', '%'.$value.'%');
            }
        }

        return $queryBuilder;
    }
}