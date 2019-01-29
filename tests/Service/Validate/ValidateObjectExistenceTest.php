<?php

namespace App\Tests\Service\Validate;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Validate\ValidateObjectExistenceService;

class ValidateObjectExistenceTest extends TestCase
{

    /** @test */
    public function is_validate_function_return_null_when_object_was_passed()
    {

        $validator = new ValidateObjectExistenceService();

        $object = new \stdClass();

        $this->assertSame(null, $validator->validate($object, 5));

    }

    /**
     *  @test
     *  @expectedException Exception
     */
    public function is_validate_function_throw_exception_when_object_was_not_passed()
    {

        $validator = new ValidateObjectExistenceService();

        $object = null;

        $validator->validate($object, 5);

    }
}
