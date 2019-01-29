<?php

namespace App\Tests\Service\Validate;

use App\Entity\Contract;
use App\Tests\FixtureAwareTestCase;
use App\Form\Contract\AddContractType;
use App\Service\Validate\ValidateContractService;

class ValidateContractServiceTest extends FixtureAwareTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    
    protected function setUp()
    {
        parent::setUp();

        // Boot up the Symfony Kernel
        $kernel = static::bootKernel();
        // Lets get the entityManager from the container
        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        $this->factory = $kernel->getContainer()->get('form.factory');
    }

    /** @test */
    public function check_if_validator_returns_array()
    {

        $validator = new ValidateContractService($this->entityManager);

        $contract = new Contract;

        $form = $this->factory->create(AddContractType::class, $contract);

        $this->assertSame([], $validator->validate($form, 5));

    }
}
