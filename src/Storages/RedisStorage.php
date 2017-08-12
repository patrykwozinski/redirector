<?php

namespace Freeq\Redirector\Storages;

use Predis\Client;
use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Contracts\StorageInterface;

class RedisStorage extends AbstractStorage implements StorageInterface
{
    private $connection;

    public function __construct(Client $connection)
    {
        $this->connection = $connection;
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
                $this->getExpireInSeconds()
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

    private function getExpireInSeconds(): int
    {
        return max(0, strtotime($this->redirect->expireAt()) - time());
    }
}
