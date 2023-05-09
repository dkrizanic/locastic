<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\EventStore;

use App\Shared\Application\EventStore\Event;
use App\Shared\Application\EventStore\EventStore;
use Psr\EventDispatcher\EventDispatcherInterface;

class SymfonyEventDispatcherEventStore implements EventStore
{
    public function __construct(private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function store(Event $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }
}
