<?php

namespace App\Racer\Domain\Model;

use App\Entity\Race;

class Racer
{
    private ?int $ageCategoryPlacement = null;
    private ?int $overallPlacement = null;

    public function __construct(
        public readonly string $id,
        private string $fullName,
        private int $finishTime,
        private string $distance,
        private string $ageCategory,
        private Race $race,
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

    public function setAgeCategoryPlacement(?int $ageCategoryPlacement): void
    {
        $this->ageCategoryPlacement = $ageCategoryPlacement;
    }

    public function setOverallPlacement(?int $overallPlacement): void
    {
        $this->overallPlacement = $overallPlacement;
    }
}
