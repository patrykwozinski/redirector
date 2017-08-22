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
    public function test_Build_Wrong_Exception()
    {
        StorageFactory::build('wrong_name', null);
    }

    public function test_Build_Redis_InstanceOfAbstract()
    {
        $storage = StorageFactory::build('redis', null);
    }

    public function test_Build_File_InstanceOfAbstract()
    {
        $storage = StorageFactory::build('file', null);
    }
}
