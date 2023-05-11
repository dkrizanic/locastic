<?php

declare(strict_types=1);

namespace App\Racer\Domain\DTO;

use App\Shared\Domain\DTO\SheetRowDataDTO;

class RacerImportSheetRowDataDTO extends SheetRowDataDTO
{
    final public const RACER_FULL_NAME_COLUMN = 'A';
    final public const RACER_DISTANCE_COLUMN = 'B';
    final public const RACER_FINISH_TIME_COLUMN = 'C';
    final public const RACER_AGE_CATEGORY_COLUMN = 'D';

    public function shouldSkipReservationCreation(): bool
    {
        $requiredColumns = [
            self::RACER_FULL_NAME_COLUMN,
            self::RACER_DISTANCE_COLUMN,
            self::RACER_FINISH_TIME_COLUMN,
            self::RACER_AGE_CATEGORY_COLUMN,
        ];

        foreach ($requiredColumns as $requiredColumn) {
            if (false === isset($this->rowData[$requiredColumn]) || '' === $this->rowData[$requiredColumn]) {
                return true;
            }
        }

        return false;
    }

    public function getFullName(): string
    {
        return $this->getTrimmedString($this->rowData, self::RACER_FULL_NAME_COLUMN);
    }

    public function getDistance(): string
    {
        return $this->getTrimmedString($this->rowData, self::RACER_DISTANCE_COLUMN);
    }

    public function getFinishTime(): int
    {
        return $this->getTimeInSeconds($this->rowData, self::RACER_FINISH_TIME_COLUMN);
    }

    public function getAgeCategory(): string
    {
        return $this->getTrimmedString($this->rowData, self::RACER_AGE_CATEGORY_COLUMN);
    }
}
