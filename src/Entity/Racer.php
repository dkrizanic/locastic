<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[
    ApiResource(
        operations: [
        new GetCollection(
            uriTemplate: '/racers/{raceId}',
            uriVariables: [
                'raceId' => new Link(toProperty: 'race', fromClass: Race::class),
            ],
        ),
    ],
    ),
    ApiFilter(
        SearchFilter::class,
        properties: [
            'fullName' => SearchFilter::STRATEGY_PARTIAL,
            'distance' => SearchFilter::STRATEGY_PARTIAL,
            'ageCategory' => SearchFilter::STRATEGY_PARTIAL,
        ]
    ),
    ApiFilter(
        OrderFilter::class,
        properties: ['fullName', 'distance', 'ageCategory'],
        arguments: ['orderParameterName' => 'order']
    ),
]
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
        private int $finishTime,
        #[ORM\Column(length: 255)]
        private string $distance,
        #[ORM\Column(length: 255)]
        private string $ageCategory,
        #[ORM\ManyToOne]
        #[ORM\JoinColumn(nullable: false)]
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

    public function getFinishTime(): int
    {
        return $this->finishTime;
    }

    public function setFinishTime(int $finishTime): void
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
