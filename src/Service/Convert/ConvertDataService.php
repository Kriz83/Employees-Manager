<?php

declare(strict_types=1);

namespace App\Service\Convert;

class ConvertDataService
{
    public function convertDateStringToDatetimeObject(
        string $dateString
    ): \DateTime {
        return new \DateTime($dateString);
    }
}    
    