<?php

declare(strict_types=1);

namespace tests\acceptance\Playground\Command;

use Playground\Command\CreateOrder;
use Playground\Event\OrderCreated;
use Ramsey\Uuid\Uuid;
use tests\UsesScenarioTestCase;

class CreateOrderTest extends UsesScenarioTestCase
{
    /** @test */
    public function it_notifies_that_order_has_been_created()
    {
        $this
            ->scenario
            ->when(new CreateOrder($orderId = Uuid::uuid4(), 5))
            ->then(new OrderCreated($orderId, 5));
    }
}
