<?php

declare(strict_types=1);

namespace App\Service\Doctrine;

use App\Entity\ResourceInterface;
use Doctrine\ORM\EntityManagerInterface;

class ResourcePersister
{
    public function __construct(
        private EntityManagerInterface $manager,
    ) {
    }

    public function persist(ResourceInterface $resource): void
    {
        $this->manager->persist($resource);
        $this->manager->flush();
    }

    public function remove(ResourceInterface $resource): void
    {
        $this->manager->remove($resource);
        $this->manager->flush();
    }
}