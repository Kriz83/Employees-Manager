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
            /*
                change query statement depend on value
                (could create problem when user want to search by number (in some rare cases like building number))
            */
            if ($value == null) {    
                //prevent search when value is null for query creating
                $key = ''; 
            } elseif (is_numeric($value)) {
                $statement = '=';
            } else {
                $statement = 'LIKE';
                $value = '%'.$value.'%';
            }

            if ($key != '') {
                $queryBuilder
                    ->andWhere('a.'.$key.' '.$statement.' :'.$key.'')
                    ->setParameter(''.$key.'', $value);
            }
        }

        return $queryBuilder;
    }
}