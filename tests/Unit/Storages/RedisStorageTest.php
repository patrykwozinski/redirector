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

    public function setUp()
    {
        parent::setUp();
        $this->redirect = $this->getMockBuilder(Redirectable::class)
            ->getMock();

        $this->redirect->method('hash')
            ->willReturn(md5('filename'));
        $this->redirect->method('expireAt')
            ->willReturn('2020-02-02');
    }

    public function test_Constructor_Redirectable_Ok()
    {
        $storage = new RedisStorage($this->createMock(Client::class));
        $storage->setRedirect($this->redirect);

        $this->assertInstanceOf(AbstractStorage::class, $storage);
        $this->assertInstanceOf(StorageInterface::class, $storage);
    }

    public function test_Store_WithExpire_Ok()
    {

    }

    public function test_Store_WithoutExpire_Ok()
    {
        //
    }
}
