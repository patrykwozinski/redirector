<?php

namespace Redirector;

use Redirector\Contracts\StorageInterface;
use Redirector\Exceptions\CannotCreateStorage;

abstract class StorageFactory
{
    const NAMESPACE = '\Redirector\Storages\\';
    const STORAGE_SUFIX = 'Storage';

    public static function build(array $storage): StorageInterface
    {
        $storage_path = static::NAMESPACE
            . ucfirst($storage['type'])
            . static::STORAGE_SUFIX;

        if (class_exists($storage_path)) {
            return new $storage_path($storage['params']);
        }

        throw CannotCreateStorage::driverDoesntExists($storage_type);
    }
}
