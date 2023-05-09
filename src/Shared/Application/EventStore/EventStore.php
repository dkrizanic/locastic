<?php

namespace App\Shared\Application\EventStore;

interface EventStore
{
    public function store(Event $event): void;
}
