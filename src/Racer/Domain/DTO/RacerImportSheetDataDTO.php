<?php

declare(strict_types=1);

namespace App\Racer\Domain\DTO;

class RacerImportSheetDataDTO
{
    private int $dataCount;

    /**
     * @param array<int, array<string, mixed>> $data
     */
    public function __construct(
        private readonly array $data,
        private readonly int $headerRowsCount,
        private readonly string $raceTitle,
        private readonly \DateTimeImmutable $raceDate,
    ) {
        $this->dataCount = count($this->data);
    }

    public function getData(): \Generator
    {
        foreach ($this->data as $rowIndex => $rowData) {
            yield new RacerImportSheetRowDataDTO($rowData, $rowIndex + $this->headerRowsCount);
        }
    }

    public function getCount(): int
    {
        return $this->dataCount;
    }

    public function getRaceDate(): \DateTimeImmutable
    {
        return $this->raceDate;
    }

    public function getRaceTitle(): string
    {
        return $this->raceTitle;
    }
}
