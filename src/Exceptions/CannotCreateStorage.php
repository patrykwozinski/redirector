<?php

namespace Freeq\Redirector\Exceptions;

use Exception;

class CannotCreateStorage extends Exception
{
    public static function classDoesntExists(string $class_name): self
    {
        return new self("Class {$class_name} doesn't exists.");
    }
}
