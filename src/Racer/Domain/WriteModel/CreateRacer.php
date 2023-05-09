<?php

declare(strict_types=1);

namespace App\Racer\Domain\WriteModel;

class CreateRacer
{
    public function __construct(
        public readonly string $id,
        public readonly string $fullName,
        public readonly string $distance,
        public readonly \DateTimeImmutable $finishTime,
        public readonly string $ageCategory,
        public readonly string $raceId,
        public readonly ?string $overallPlacement = null,
        public readonly ?string $ageCategoryPlacement = null,
    ) {
    }
}
