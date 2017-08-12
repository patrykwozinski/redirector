<?php

namespace Redirector;

use Redirector\StorageFactory;
use Redirector\Contracts\Redirectable;

class Manager
{
    private $storage;
    private $redirect;

    public function __construct(array $storage_params = [], Redirectable $redirect = null)
    {
        $this->storage = StorageFactory::build($storage_params)
            ->setRedirect($redirect);
        $this->redirect = $redirect;
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
