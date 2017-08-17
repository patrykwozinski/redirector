<?php

namespace Freeq\Redirector\Storages;

use Freeq\Redirector\Helpers\KeyMaker;
use Freeq\Redirector\Contracts\Redirectable;

abstract class AbstractStorage
{
    use KeyMaker;

    protected $redirect;
    protected $keys = ['from', 'to', 'status_http'];

    public abstract function get(string $keyword): ?array;

    public abstract function store(): void;

    public abstract function delete(): void;

    public abstract function flush(): void;

    public function setRedirect(Redirectable $redirect = null): self
    {
        $this->redirect = $redirect;

        return $this;
    }

    protected function makeFileContent(): string
    {
        return $this->redirect->routeFrom()
            . ';' . $this->redirect->routeTo()
            . ';' . $this->redirect->statusHttp();
    }
}
