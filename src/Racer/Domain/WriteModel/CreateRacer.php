<?php

declare(strict_types=1);

namespace App\Racer\Domain\WriteModel;

class CreateRacer
{
    public function __construct(
        public readonly string $id,
        public readonly string $fullName,
        public readonly string $distance,
        public readonly int $finishTime,
        public readonly string $ageCategory,
        public readonly string $raceId,
        public readonly ?int $overallPlacement = null,
        public readonly ?int $ageCategoryPlacement = null,
    ) {
    }
}
