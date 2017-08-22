<?php

namespace Freeq\Redirector;

use Freeq\Redirector\Storages\AbstractStorage;
use Freeq\Redirector\Exceptions\CannotCreateStorage;

abstract class StorageFactory
{
    const STORAGE_PATH = '\Freeq\Redirector\Storages\\';
    const STORAGE_SUFIX = 'Storage';

    public static function build(string $type, $configuration): AbstractStorage
    {
        $class_path = static::STORAGE_PATH . ucfirst($type) . static::STORAGE_SUFIX;

        if (class_exists($class_path)) {
            return new $class_path($configuration);
        }

        throw CannotCreateStorage::classDoesntExists($class_path);
    }
}
