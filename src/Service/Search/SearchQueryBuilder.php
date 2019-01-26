<?php

namespace App\Service\Search;

use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Form\FormInterface;
use App\Service\Search\SearchQueryBuilderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchQueryBuilder implements SearchQueryBuilderInterface
{
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }

    public function rebuildQuery(FormInterface $form, $queryBuilder, $entityFieldNames)
    {
        $formData = $form->getData();
       
        //add queries to main query depend on filled form fields
        foreach ($formData as $key => $value) {
            
            /*
                1. Prevent date searches
                (QueryBuilder can not decide which instruction should be used - whether a specific date or date in the range is to be found)
                The date query should be used elsewhere
                2. Prevent from query creating when value is null
            */
            if ($value instanceof \DateTime || $value == null) {
                continue;
            }

            /*
                change query statement depend on value
                (could create problem when user want to search by number (in some rare cases like building number))
            */
            if (in_array($key, $entityFieldNames)) {
                //set default query statement
                $statement = '=';
          
                if (!is_numeric($value)) {
                    //text search
                    $statement = 'LIKE';
                    $value = '%'.$value.'%';
                }
    
                $queryBuilder
                    ->andWhere('a.'.$key.' '.$statement.' :'.$key.'')
                    ->setParameter(''.$key.'', $value);

            } else {

                $this->logger->critical(
                    sprintf('Not found: "%s", Entity column. Change form field name to match existing Entity column.', $key)
                );
                throw new NotFoundHttpException(
                    sprintf('Not found: "%s", Entity column. Change form field name to match existing Entity column.', $key)
                );

            }         
            
        }

        return $queryBuilder;
    }

}