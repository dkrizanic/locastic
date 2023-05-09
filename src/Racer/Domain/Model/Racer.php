<?php

namespace App\Racer\Domain\Model;

class Racer
{
    private ?int $ageCategoryPlacement = null;
    private ?int $overallPlacement = null;

    public function __construct(
        public readonly string $id,
        private string $fullName,
        private \DateTimeImmutable $finishTime,
        private string $distance,
        private string $ageCategory,
        private string $raceId,
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

    public function getFinishTime(): \DateTimeImmutable
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

    public function getRaceId(): string
    {
        return $this->raceId;
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
