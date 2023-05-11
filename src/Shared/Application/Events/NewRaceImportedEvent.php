<?php

namespace App\Shared\Application\Events;

use App\Shared\Application\EventStore\Event;

class NewRaceImportedEvent implements Event
{
    public function __construct(
        private readonly string $raceId,
        private readonly string $raceTitle,
        private readonly \DateTimeImmutable $raceDate,
    ) {
    }

    public function getRaceTitle(): string
    {
        return $this->raceTitle;
    }

    public function getRaceDate(): \DateTimeImmutable
    {
        return $this->raceDate;
    }

    public function getRaceId(): string
    {
        return $this->raceId;
    }
}
