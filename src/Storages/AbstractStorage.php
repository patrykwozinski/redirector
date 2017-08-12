<?php

namespace Redirector\Storages;

use Redirector\Helpers\KeyMaker;
use Redirector\Contracts\Redirectable;

abstract class AbstractStorage
{
    use KeyMaker;

    protected $redirect;
    protected $keys = ['from', 'to', 'status_http'];

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
