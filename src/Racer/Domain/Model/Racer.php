<?php

namespace App\Racer\Domain\Model;

use App\Entity\Race;

class Racer
{
    public function __construct(
        public readonly string $id,
        private readonly string $fullName,
        private readonly int $finishTime,
        private readonly string $distance,
        private readonly string $ageCategory,
        private readonly Race $race,
        private readonly ?int $ageCategoryPlacement = null,
        private readonly ?int $overallPlacement = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getFinishTime(): int
    {
        return $this->finishTime;
    }

    public function getDistance(): string
    {
        return $this->distance;
    }

    public function getAgeCategory(): string
    {
        return $this->ageCategory;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function getOverallPlacement(): ?int
    {
        return $this->overallPlacement;
    }

    public function getAgeCategoryPlacement(): ?int
    {
        return $this->ageCategoryPlacement;
    }
}
