<?php

namespace Tests\Unit;

use Freeq\Redirector\Manager;
use PHPUnit\Framework\TestCase;
use Freeq\Redirector\Contracts\Redirectable;
use Freeq\Redirector\Contracts\StorageInterface;

class ManagerTest extends TestCase
{
    private $redirect;
    private $manager;

    public function setUp()
    {
        parent::setUp();

        $this->redirect = $this->getMockBuilder(Redirectable::class)->getMock();
        $this->redirect->method('hash')->willReturn(md5('filename'));

        mkdir(__DIR__ . '/redirects');

        $this->manager = new Manager([
            'type' => 'file',
            'source' => __DIR__ . '/redirects',
        ], $this->redirect);
    }

    public function test_Constructor_Ok()
    {
        $this->assertInstanceOf(Manager::class, $this->manager);
    }

    public function test_Store_Ok()
    {
        $this->manager->store();
    }

    public function test_Delete_Ok()
    {
        $this->manager->delete();
    }

    public function test_Flush_Ok()
    {
        $this->manager->flush();
    }

    public function tearDown()
    {
        array_map('unlink', glob(__DIR__ . '/redirects/*'));
        rmdir(__DIR__ . '/redirects');

        parent::tearDown();
    }
}
