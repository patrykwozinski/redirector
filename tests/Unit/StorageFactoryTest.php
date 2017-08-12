<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Freeq\Redirector\StorageFactory;
use Freeq\Redirector\Exceptions\CannotCreateStorage;

class StorageFactoryTest extends TestCase
{
    /**
     * @expectedException Freeq\Redirector\Exceptions\CannotCreateStorage
     */
    public function test_Build_IncorrectData_ThrowsException()
    {
        StorageFactory::build(['type' => 'wrong', 'params' => null]);
    }
}
