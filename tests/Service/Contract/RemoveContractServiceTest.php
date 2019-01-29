<?php

namespace App\Tests\Service\Validate;

use App\Entity\Contract;
use App\Tests\FixtureAwareTestCase;
use App\Service\Contract\RemoveContractService;

class RemoveContractServiceTest extends FixtureAwareTestCase
{
    
    protected function setUp()
    {
        parent::setUp();
        // Boot up the Symfony Kernel
        $kernel = static::bootKernel();
        // Lets get the entityManager from the container
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();

        $this->contract = new Contract;
        $this->removeContractService = new RemoveContractService($this->entityManager);
    }

    /** @test */
    public function test_if_remove_method_returns_null_after_remove()
    {

        $this->assertSame(null, $this->removeContractService->removeContract($this->contract));

    }

    /**
     *  @test
     *  @expectedException Exception
     */
    public function test_if_remove_method_throw_exception_when_contract_object_was_not_passed()
    {

        $this->contract = null;

        $this->removeContractService->removeContract($this->contract);
    }
}
