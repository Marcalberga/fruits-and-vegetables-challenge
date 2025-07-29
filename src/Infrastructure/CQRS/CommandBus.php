<?php

namespace App\Infrastructure\CQRS;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CommandBus
{
    public function __construct(private MessageBusInterface $queryBus) {}

    public function execute(object $query): mixed
    {
        $envelope = $this->queryBus->dispatch($query);
        $stamp = $envelope->last(HandledStamp::class);
        return $stamp?->getResult();
    }
}