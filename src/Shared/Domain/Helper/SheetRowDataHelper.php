<?php

declare(strict_types=1);

namespace App\Shared\Domain\Helper;

trait SheetRowDataHelper
{
    /**
     * @param array<string, mixed> $rowData
     */
    protected function getTrimmedString(array $rowData, string $column): string
    {
        return trim($rowData[$column] ?? '');
    }

    /**
     * @param array<string, mixed> $rowData
     */
    protected function getTimeInSeconds(array $rowData, string $column): int
    {
        $rawValue = $this->getTrimmedString($rowData, $column);

        return $this->convertTimeToSeconds($rawValue);
    }

    protected function convertTimeToSeconds(string $time): int
    {
        sscanf($time, '%d:%d:%d', $hours, $minutes, $seconds);
        if (is_numeric($hours) === true && is_numeric($minutes) === true) {
            return (int) (($hours * 3600) + ($minutes * 60) + $seconds);
        }

        return 0;
    }
}
