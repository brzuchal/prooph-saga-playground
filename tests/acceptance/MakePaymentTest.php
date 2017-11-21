<?php

declare(strict_types=1);

namespace tests\acceptance;

use Application\Command\MakePayment;
use Domain\Payment\PaymentAccepted;
use Ramsey\Uuid\Uuid;
use tests\UsesScenarioTestCase;

class MakePaymentTest extends UsesScenarioTestCase
{
    /** @test */
    public function it_notifies_that_payment_has_been_accepted()
    {
        $this
            ->scenario
            ->when(new MakePayment($paymentId = Uuid::uuid4(), 5 * 100))
            ->then(new PaymentAccepted($paymentId, 500));
    }
}
