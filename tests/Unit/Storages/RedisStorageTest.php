<?php

namespace Tests\Unit;

use Predis\Client;
use PHPUnit\Framework\TestCase;
use Freeq\Redirector\Storages\RedisStorage;
use Freeq\Redirector\Contracts\Redirectable;
use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Contracts\StorageInterface;

class RedisStorageTest extends TestCase
{
    private $redirect;
    private $storage;

    public function setUp()
    {
        parent::setUp();
        $this->redirect = $this->getMockBuilder(Redirectable::class)
            ->getMock();

        $this->redirect->method('hash')
            ->willReturn(md5('filename'));

        $this->storage = new RedisStorage($this->createMock(Client::class));
        $this->storage->setRedirect($this->redirect);
    }

    public function test_Constructor_Redirectable_Ok()
    {
        $this->assertInstanceOf(AbstractStorage::class, $this->storage);
        $this->assertInstanceOf(StorageInterface::class, $this->storage);
    }

    public function test_Store_WithExpire_Expired_Ok()
    {
        $this->redirect->method('expireAt')
            ->willReturn('2000-01-01');

        $this->storage->store();

        $this->assertEmpty($this->storage->get('filename'));
    }

    public function test_Delete_Ok()
    {
        try {
            $this->storage->delete();
        } catch (\Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }

    public function test_Flush_Ok()
    {
        try {
            $this->storage->flush();
        } catch (\Exception $e) {
            $this->fail();
        }

        $this->assertTrue(true);
    }
}
