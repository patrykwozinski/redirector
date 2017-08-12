<?php

namespace Freeq\Redirector\Storages;

use Predis\Client;
use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Contracts\StorageInterface;

class RedisStorage extends AbstractStorage implements StorageInterface
{
    private $connection;

    public function __construct(array $connection)
    {
        $this->connection = new Client($connection);
    }

    public function get(string $keyword): ?array
    {
        $parameters = $this->connection->get($this->makeKey($keyword));

        return empty($parameters) ? null : array_combine($this->keys, explode(';', $parameters));
    }

    public function store(): void
    {
        $this->connection->set($this->redirect->hash(), $this->makeFileContent());

        if ($this->redirect->expireAt()) {
            $this->connection->expireAt(
                $this->redirect->hash(),
                strtotime($this->redirect->expireAt())
            );
        }
    }

    public function delete(): void
    {
        $this->connection->del($this->redirect->hash());
    }

    public function flush(): void
    {
        $this->connection->FLUSHDB();
    }
}
