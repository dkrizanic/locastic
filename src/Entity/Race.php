<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Unique;

#[ORM\Entity]
#[
    ApiResource(operations: [
        new GetCollection(
            name: 'races',
            uriTemplate: '/races',
        ),
    ]),
    ApiFilter(
        SearchFilter::class,
        properties: [
            'title' => SearchFilter::STRATEGY_PARTIAL,
        ]
    ),
    ApiFilter(
        OrderFilter::class,
        properties: ['title', 'dateTime', 'averageFinishTimeMedium', 'averageFinishTimeLong'],
        arguments: ['orderParameterName' => 'order']
    ),
]
class Race
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        private string $id,
        #[ORM\Column(length: 255), unique]
        private string $title,
        #[ORM\Column(type: Types::DATETIME_MUTABLE)]
        private \DateTime $dateTime,
        #[ORM\Column]
        private int $averageFinishTimeMedium,
        #[ORM\Column]
        private int $averageFinishTimeLong,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function getAverageFinishTimeMedium(): int
    {
        return $this->averageFinishTimeMedium;
    }

    public function getAverageFinishTimeLong(): int
    {
        return $this->averageFinishTimeLong;
    }

    public function setAverageFinishTimeLong(int $averageFinishTimeLong): void
    {
        $this->averageFinishTimeLong = $averageFinishTimeLong;
    }

    public function setAverageFinishTimeMedium(int $averageFinishTimeMedium): void
    {
        $this->averageFinishTimeMedium = $averageFinishTimeMedium;
    }
}
