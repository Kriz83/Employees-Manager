<?php

namespace App\Tests\Service\Doctrine;

use App\Entity\ResourceInterface;
use App\Service\Doctrine\ResourcePersister;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ResourcePersisterTest extends TestCase
{
    private EntityManagerInterface $manager;
    private ResourcePersister $resourcePersister;

    protected function setUp(): void
    {
        $this->manager = $this->createMock(EntityManagerInterface::class);
        $this->resourcePersister = new ResourcePersister($this->manager);
    }

    public function testPersist(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $this->manager->expects($this->once())
            ->method('persist')
            ->with($resource);

        $this->manager->expects($this->once())
            ->method('flush');

        $this->resourcePersister->persist($resource);
    }

    public function testRemove(): void
    {
        $resource = $this->createMock(ResourceInterface::class);

        $this->manager->expects($this->once())
            ->method('remove')
            ->with($resource);

        $this->manager->expects($this->once())
            ->method('flush');

        $this->resourcePersister->remove($resource);
    }
}