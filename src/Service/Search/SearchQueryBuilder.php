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

    public function rebuildQuery(FormInterface $form, $queryBuilder, $entityColumnNames)
    {
        $formData = $form->getData();

        //add queries to main query depend on filled form fields
        foreach ($formData as $key => $value) {
            /*
                change query statement depend on value
                (could create problem when user want to search by number (in some rare cases like building number))
            */
            if (in_array($key, $entityColumnNames)) {

                if ($value == null) {    
                    //prevent search when value is null for query creating
                    continue;
                } elseif (is_numeric($value)) {
                    $statement = '=';
                } else {
                    $statement = 'LIKE';
                    $value = '%'.$value.'%';
                }
    
                $queryBuilder
                    ->andWhere('a.'.$key.' '.$statement.' :'.$key.'')
                    ->setParameter(''.$key.'', $value);
            } else {
                $this->logger->critical(
                    sprintf('Not found: "%s", ORM column. Change form field name to match existing ORM column.', $key)
                );
                throw new NotFoundHttpException(
                    sprintf('Not found: "%s", ORM column. Change form field name to match existing ORM column.', $key)
                );
            }         
            
        }

        return $queryBuilder;
    }
}