<?php

declare(strict_types=1);

namespace tests\integration\Console\Output;

use Console\Middleware\CollectsMessages;
use Console\Output\TableWithMessages;
use Messaging\Command\CreateOrder;
use Messaging\Event\OrderCreated;
use Prooph\Common\Event\ActionEvent;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Output\BufferedOutput;
use tests\UsesContainerTestCase;

class TableWithMessagesTest extends UsesContainerTestCase
{
    /** @var CollectsMessages */
    private $collectsMessages;

    /** @var TableWithMessages */
    private $tableWithMessages;

    /** @test */
    public function it_can_display_table_with_command_message()
    {
        $this->collectMessages(new CreateOrder(Uuid::uuid4(), 5));

        $output = $this->display();

        $this->assertContains('Command', $output);
        $this->assertContains('CreateOrder', $output);
    }

    /** @test */
    public function it_can_display_table_with_domain_event_message()
    {
        $this->collectMessages(new OrderCreated(Uuid::uuid4(), 5));

        $output = $this->display();

        $this->assertContains('DomainEvent', $output);
        $this->assertContains('OrderCreated', $output);
    }

    /** @test */
    public function it_can_display_payload_of_message()
    {
        $this->collectMessages($message = new OrderCreated(Uuid::uuid4(), 5));

        $output = $this->display();

        $this->assertContains(json_encode($message->payload()), $output);
    }

    /** @test */
    public function it_can_display_table_with_multiple_messages()
    {
        $this->collectMessages(
            new CreateOrder(Uuid::uuid4(), 5),
            new OrderCreated(Uuid::uuid4(), 5)
        );

        $output = $this->display();

        $this->assertContains('Command', $output);
        $this->assertContains('DomainEvent', $output);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->collectsMessages  = $this->container()->get(CollectsMessages::class);
        $this->tableWithMessages = $this->container()->get(TableWithMessages::class);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->collectsMessages  = null;
        $this->tableWithMessages = null;
    }

    private function collectMessages(...$messages)
    {
        foreach ($messages as $message) {
            $actionEvent = $this->prophesize(ActionEvent::class);

            $actionEvent->getParam(Argument::any())
                ->willReturn($message);

            ($this->collectsMessages)($actionEvent->reveal());
        }
    }

    private function display(): string
    {
        $this->tableWithMessages->display($output = new BufferedOutput());

        return $output->fetch();
    }
}
