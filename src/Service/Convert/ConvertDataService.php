<?php

namespace App\Service\Convert;

class ConvertDataService
{
    public function convertDateStringToDatetimeObject(string $dateString)
    {
        return new \DateTime($dateString);
    }
}    
    