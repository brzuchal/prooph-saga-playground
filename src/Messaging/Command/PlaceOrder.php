<?php

declare(strict_types=1);

namespace Messaging\Command;

use Messaging\Command;
use Messaging\ReturnsPayload;
use Ramsey\Uuid\UuidInterface;

class PlaceOrder implements Command
{
    use ReturnsPayload;

    /** @var UuidInterface */
    public $orderId;

    /** @var int */
    public $numberOfSeats;

    public function __construct(UuidInterface $orderId, int $numberOfSeats)
    {
        $this->orderId       = $orderId;
        $this->numberOfSeats = $numberOfSeats;
    }

    public function aggregateId(): UuidInterface
    {
        return $this->orderId;
    }
}
