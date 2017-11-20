<?php

declare(strict_types=1);

namespace Domain\Order;

use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\UuidInterface;

final class OrderCreated extends AggregateChanged
{
    public function __construct(UuidInterface $reservationId, int $numberOfSeats)
    {
        parent::__construct($reservationId->toString(), ['numberOfSeats' => $numberOfSeats]);
    }

    public function numberOfSeats(): int
    {
        return $this->payload['numberOfSeats'];
    }
}
