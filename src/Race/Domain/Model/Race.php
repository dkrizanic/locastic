<?php

namespace App\Race\Domain\Model;

class Race
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly \DateTimeImmutable $dateTime,
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

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }
}
