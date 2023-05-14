<?php

declare(strict_types=1);

namespace App\Race\Domain\WriteModel;

class UpdateRace
{
    public function __construct(
        public readonly string $id,
        public readonly int $averageFinishTimeMedium,
        public readonly int $averageFinishTimeLong,
    ) {
    }
}
