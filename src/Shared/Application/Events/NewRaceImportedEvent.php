<?php

namespace App\Shared\Application\Events;

use App\Shared\Application\EventStore\Event;

class NewRaceImportedEvent implements Event
{
    public function __construct(
        private readonly string $raceId,
        private readonly string $raceTitle,
        private readonly \DateTime $raceDate,
        private readonly int $averageFinishTimeMedium,
        private readonly int $averageFinishTimeLong,
    ) {
    }

    public function getRaceTitle(): string
    {
        return $this->raceTitle;
    }

    public function getRaceDate(): \DateTime
    {
        return $this->raceDate;
    }

    public function getRaceId(): string
    {
        return $this->raceId;
    }

    public function getAverageFinishTimeMedium(): int
    {
        return $this->averageFinishTimeMedium;
    }

    public function getAverageFinishTimeLong(): int
    {
        return $this->averageFinishTimeLong;
    }
}
