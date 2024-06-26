<?php

declare(strict_types=1);

namespace App\Race\Domain\WriteModel;

class CreateRace
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly \DateTime $dateTime,
        public readonly int $averageFinishTimeMedium,
        public readonly int $averageFinishTimeLong,
    ) {
    }
}
