<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Freeq\Redirector\Storages\FileStorage;
use Freeq\Redirector\Contracts\Redirectable;
use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Contracts\StorageInterface;

class AbstractStorageTest extends TestCase
{
    private $redirect;

    public function setUp()
    {
        parent::setUp();

        mkdir(__DIR__ . '/redirects', 0775);

        $this->redirect = $this->getMockBuilder(Redirectable::class)
            ->getMock();

        $this->redirect->method('hash')
            ->willReturn('filename');
    }

    /**
     * @expectedException Freeq\Redirector\Exceptions\CannotUseFileStorage
     */
    public function test_Constructor_NotWritable_Throws()
    {
        if (is_dir(__DIR__ . '/test')) {
            mkdir(__DIR__ . '/test', 0555);
        }

        new FileStorage(__DIR__ . '/test');

    }

    public function test_SetRedirect_Redirectable_Ok()
    {
        $storage = new FileStorage(__DIR__);
        $storage->setRedirect($this->redirect);

        $this->assertInstanceOf(AbstractStorage::class, $storage);
        $this->assertInstanceOf(StorageInterface::class, $storage);
    }

    public function test_Store_CustomHash_Ok()
    {
        $storage = new FileStorage(__DIR__ . '/redirects');
        $storage->setRedirect($this->redirect);
        $storage->store();

        $this->assertTrue(file_exists(__DIR__ . '/redirects/filename'));
    }

    public function tearDown()
    {
        if (is_dir(__DIR__ . '/redirects')) {
            array_map('unlink', glob(__DIR__ . '/redirects/*'));
            rmdir(__DIR__ . '/redirects');
        }

        if (is_dir(__DIR__ . '/test')) {
            rmdir(__DIR__ . '/test');    
        }

        parent::tearDown();
    }
}
