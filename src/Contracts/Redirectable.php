<?php

namespace Redirector\Contracts;

interface Redirectable
{
    public function routeFrom(): string;

    public function routeTo(): string;

    public function statusHttp(): int;

    public function hash(): string;

    public function expireAt(): ?string;
}
