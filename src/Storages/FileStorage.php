<?php

namespace Freeq\Redirector\Storages;

use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Exceptions\CannotUseFileStorage;

class FileStorage extends AbstractStorage
{
    private $storage_path;

    public function __construct(string $storage_path)
    {
        $this->storage_path = $storage_path;
        $this->assertValidStoragePath();
    }

    public function get(string $keyword): ?array
    {
        $parameters = [];
        $file_path = $this->getFilePath($this->makeKey($keyword));

        if (file_exists($file_path)) {
            $parameters = explode(';', (file_get_contents($file_path)));
        }

        return empty($parameters) ? null : array_combine($this->keys, $parameters);
    }

    public function store(): void
    {
        fwrite(
            fopen($this->getFilePath(), 'w'),
            $this->makeFileContent()
        );
    }

    public function delete(): void
    {
        if (file_exists($this->getFilePath())) {
            unlink($this->getFilePath());
        }
    }

    public function flush(): void
    {
        array_map('unlink', glob($this->storage_path . '/*'));
    }

    private function assertValidStoragePath(): void
    {
        if (! is_writable($this->storage_path)) {
            throw CannotUseFileStorage::incorrectPath($this->storage_path);
        }
    }

    private function getFilePath(?string $search_hash = null): string
    {
        $hash = $search_hash ?? $this->redirect->hash();

        return "{$this->storage_path}/{$hash}";
    }
}
