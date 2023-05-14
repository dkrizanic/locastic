<?php

namespace App\Shared\Application\Events;

use App\Shared\Application\EventStore\Event;

class UpdateRaceAverageFinishTimeEvent implements Event
{
    public function __construct(
        private readonly string $raceId,
        private readonly int $averageFinishTimeMedium,
        private readonly int $averageFinishTimeLong,
    ) {
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
