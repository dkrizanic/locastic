<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Race
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column]
        private string $id,
        #[ORM\Column(length: 255)]
        private string $title,
        #[ORM\Column(type: Types::DATETIME_MUTABLE)]
        private \DateTimeImmutable $dateTime,
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeImmutable $dateTime): void
    {
        $this->dateTime = $dateTime;
    }
}
