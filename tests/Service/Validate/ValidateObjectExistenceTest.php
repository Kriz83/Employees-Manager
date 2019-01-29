<?php

namespace App\Tests\Service\Validate;

use App\Tests\FixtureAwareTestCase;
use App\Service\Validate\ValidateObjectExistenceService;

class ValidateObjectExistenceTest extends FixtureAwareTestCase
{
    
    protected function setUp()
    {
        $this->validator = new ValidateObjectExistenceService();
        $this->object = new \stdClass();
    }

    /** @test */
    public function is_validate_function_return_null_when_object_was_passed()
    {

        $this->assertSame(null, $this->validator->validate($this->object, 5));

    }

    /**
     *  @test
     *  @expectedException Exception
     */
    public function is_validate_function_throw_exception_when_object_was_not_passed()
    {

        $this->object = null;

        $this->validator->validate($this->object, 5);

    }
}
