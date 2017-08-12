<?php

namespace Freeq\Redirector\Helpers;

trait KeyMaker
{
    protected function makeKey(string $word): string
    {
        return md5(trim($word));
    }
}
