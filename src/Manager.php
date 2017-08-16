<?php

namespace Freeq\Redirector;

use Freeq\Redirector\StorageFactory;
use Freeq\Redirector\Contracts\Redirectable;
use Freeq\Redirector\Storages\AbstractStorage;

class Manager
{
    private $storage;

    public function __construct(AbstractStorage $storage)
    {
        $this->storage = $storage;
    }

    public function forward(string $current_route = ''): void
    {
        $forwarding = $this->storage->get($current_route);

        if ($forwarding) {
            header('Location: ' . $forwarding['to'], true, $forwarding['status_http']);
            exit();
        }
    }

    public function store(): void
    {
        $this->storage->store();
    }

    public function delete(): void
    {
        $this->storage->delete();
    }

    public function flush(): void
    {
        $this->storage->flush();
    }
}
