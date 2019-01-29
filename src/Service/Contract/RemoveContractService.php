<?php

namespace App\Service\Contract;

use Psr\Log\NullLogger;
use Psr\Log\LoggerAwareTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoveContractService
{
    use LoggerAwareTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->logger = new NullLogger();
    }

    public function removeContract($contract)
    {
        try {
            $this->em->remove($contract);
            $this->em->flush();
        } catch(ORMInvalidArgumentException $e) {
            $this->logger->warning(
                sprintf('Non existing object could not be removed. %s', $e->getMessage())
            );
            throw new NotFoundHttpException(
                sprintf('Non existing object could not be removed. %s', $e->getMessage())
            );
        }
    }
}
