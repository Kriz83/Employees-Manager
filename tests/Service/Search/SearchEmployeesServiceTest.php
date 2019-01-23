<?php

namespace App\Tests\Search\Service;

use App\Service\Search\SearchEmployeesService;
use PHPUnit\Framework\TestCase;

class SearchEmployeesServiceTest extends TestCase
{
    public function searchTest()
    {
        $searchEmployeesService = new SearchEmployeesService;

        
        $searchEmployeesService->search($form);


    }
}