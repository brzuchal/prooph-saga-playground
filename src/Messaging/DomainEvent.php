<?php

declare(strict_types=1);

namespace Messaging;

interface DomainEvent
{
    public function payload(): array;
}
