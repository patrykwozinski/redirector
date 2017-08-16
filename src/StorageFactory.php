<?php

namespace Freeq\Redirector;

use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Exceptions\CannotCreateStorage;

abstract class StorageFactory
{
    const NAMESPACE = '\Freeq\Redirector\Storages\\';
    const STORAGE_SUFIX = 'Storage';

    public static function build(array $storage): AbstractStorage
    {
        $storage_path = static::NAMESPACE
            . ucfirst($storage['type'])
            . static::STORAGE_SUFIX;

        if (class_exists($storage_path)) {
            return new $storage_path($storage['source']);
        }

        throw CannotCreateStorage::driverDoesntExists($storage['type']);
    }
}
