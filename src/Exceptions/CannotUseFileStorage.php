<?php

namespace Freeq\Redirector\Exceptions;

use Exception;

class CannotUseFileStorage extends Exception
{
    public static function incorrectPath(string $path): self
    {
        return new static("Cant use path for your application. It doesnt exists or is not writable: {$path}");
    }
}
