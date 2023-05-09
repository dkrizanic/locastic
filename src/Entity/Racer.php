<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Racer
{
    #[ORM\Column(nullable: true)]
    private ?int $ageCategoryPlacement = null;

    #[ORM\Column(nullable: true)]
    private ?int $overallPlacement = null;

    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        private string $id,
        #[ORM\Column(length: 255)]
        private string $fullName,
        #[ORM\Column]
        private \DateTimeImmutable $finishTime,
        #[ORM\Column(length: 255)]
        private string $distance,
        #[ORM\Column(length: 255)]
        private string $ageCategory,
        #[ORM\ManyToOne]
        #[ORM\JoinColumn(nullable: false)]
        private Race $race,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getAgeCategory(): string
    {
        return $this->ageCategory;
    }

    public function setAgeCategory(string $ageCategory): void
    {
        $this->ageCategory = $ageCategory;
    }

    public function getFinishTime(): \DateTimeImmutable
    {
        return $this->finishTime;
    }

    public function setFinishTime(\DateTimeImmutable $finishTime): void
    {
        $this->finishTime = $finishTime;
    }

    public function getOverallPlacement(): ?int
    {
        return $this->overallPlacement;
    }

    public function setOverallPlacement(?int $overallPlacement): void
    {
        $this->overallPlacement = $overallPlacement;
    }

    public function getAgeCategoryPlacement(): ?int
    {
        return $this->ageCategoryPlacement;
    }

    public function setAgeCategoryPlacement(?int $ageCategoryPlacement): void
    {
        $this->ageCategoryPlacement = $ageCategoryPlacement;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function setRace(Race $race): void
    {
        $this->race = $race;
    }

    public function getDistance(): string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): void
    {
        $this->distance = $distance;
    }
}
