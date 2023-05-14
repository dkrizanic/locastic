<?php

namespace App\Race\Domain\Model;

class Race
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly \DateTime $dateTime,
        public readonly string $averageFinishTimeMedium,
        public readonly string $averageFinishTimeLong,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function getAverageFinishTimeMedium(): string
    {
        return $this->averageFinishTimeMedium;
    }

    public function getAverageFinishTimeLong(): string
    {
        return $this->averageFinishTimeLong;
    }
}
