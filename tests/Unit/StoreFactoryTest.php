<?php

namespace Tests\Unit;

use Predis\Client;
use PHPUnit\Framework\TestCase;
use Freeq\Redirector\StorageFactory;
use Freeq\Redirector\Storages\AbstractStorage;
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
        $predis = $this->getMockBuilder(Client::class)->getMock();

        $this->assertInstanceOf(
            AbstractStorage::class, StorageFactory::build('redis', $predis)
        );
    }

    public function test_Build_File_InstanceOfAbstract()
    {
        $this->assertInstanceOf(
            AbstractStorage::class,
            StorageFactory::build('file', __DIR__)
        );
    }
}
