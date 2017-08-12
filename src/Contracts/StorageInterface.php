<?php

namespace Freeq\Redirector\Contracts;

use Freeq\Redirector\Contracts\Redirectable;

interface StorageInterface
{
    public function get(string $keyword): ?array;

    public function store(): void;

    public function delete(): void;

    public function flush(): void;
}
