<?php

declare(strict_types=1);

namespace App\Service\Validate;

use Psr\Log\NullLogger;

use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ValidateObjectExistenceService
{
    use LoggerAwareTrait;

    public function __construct()
    {
        $this->logger = new NullLogger();
    }
    
    public function validate($object, int $searchedId): void
    {
        if (!$object) {
            $this->logger->warning(
                sprintf('Object with id: %s, could not be found.', $searchedId)
            );
            throw new NotFoundHttpException(
                sprintf('Object with id: %s, could not be found.', $searchedId)
            );
        }
    }
}    
    