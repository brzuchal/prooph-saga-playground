<?php

declare(strict_types=1);

namespace Domain\Reservation;

use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\UuidInterface;

final class SeatsReserved extends AggregateChanged
{
    public function __construct(UuidInterface $paymentId, int $numberOfSeats)
    {
        parent::__construct($paymentId->toString(), ['numberOfSeats' => $numberOfSeats]);
    }

    public function numberOfSeats(): int
    {
        return $this->payload['numberOfSeats'];
    }
}
