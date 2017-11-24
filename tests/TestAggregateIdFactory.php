<?php

declare(strict_types=1);

namespace tests;

use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\UuidInterface;

class TestAggregateIdFactory extends UuidFactory
{
    private $generatedIds = [];

    public function uuid(array $fields): UuidInterface
    {
        $this->generatedIds[] = $uuid = parent::uuid($fields);

        return $uuid;
    }

    public function all(): array
    {
        return $this->generatedIds;
    }
}
