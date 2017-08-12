<?php

namespace Tests\Unit;

use Predis\Client;
use PHPUnit\Framework\TestCase;
use Freeq\Redirector\StorageFactory;
use Freeq\Redirector\Contracts\StorageInterface;

class StorageFactoryTest extends TestCase
{
    /**
     * @expectedException Freeq\Redirector\Exceptions\CannotCreateStorage
     */
    public function test_Build_IncorrectData_ThrowsException()
    {
        StorageFactory::build(['type' => 'wrong', 'source' => null]);
    }

    public function test_Build_FileStorage_Ok()
    {
        $storage = StorageFactory::build([
            'type' => 'file', 'source' => __DIR__
        ]);

        $this->assertInstanceOf(StorageInterface::class, $storage);
    }

    public function test_Build_RedisStorage_Ok()
    {
        $storage = StorageFactory::build([
            'type' => 'redis', 'source' => $this->createMock(Client::class)
        ]);

        $this->assertInstanceOf(StorageInterface::class, $storage);
    }
}
