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
    protected function getInteger(array $rowData, string $column): ?int
    {
        // Integers are sometimes cast to float values in Excel files
        $rawValue = $this->getTrimmedString($rowData, $column);

        if ('' === $rawValue) {
            return null;
        }

        return (int) $rawValue;
    }

    /**
     * @param array<string, mixed> $rowData
     */
    protected function getDateTimeImmutable(array $rowData, string $column): \DateTimeImmutable
    {
        $rawValue = $this->getTrimmedString($rowData, $column);

        return new \DateTimeImmutable($rawValue);
    }
}
