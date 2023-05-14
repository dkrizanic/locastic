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
        private array $data,
        private readonly int $headerRowsCount,
        private readonly string $raceTitle,
        private readonly \DateTime $raceDate,
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

    public function getRaceDate(): \DateTime
    {
        return $this->raceDate;
    }

    public function getRaceTitle(): string
    {
        return $this->raceTitle;
    }

    /**
     * @param array<int, array<string, mixed>> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
