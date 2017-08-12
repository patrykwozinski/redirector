<?php

namespace Redirector\Exceptions;

use Exception;

class CannotCreateStorage extends Exception
{
    public static function driverDoesntExists(string $driver_name): self
    {
        return new static("Driver {$driver_name} for storage doesn't exists.");
    }
}
