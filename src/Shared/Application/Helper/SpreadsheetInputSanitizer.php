<?php

declare(strict_types=1);

namespace App\Shared\Application\Helper;

trait SpreadsheetInputSanitizer
{
    public function isValidFilePath(?string $filePath): bool
    {
        if ($filePath === null || $filePath === '' || !is_readable($filePath) || !is_file($filePath)) {
            return false;
        }

        return true;
    }

    public function getLowerCase(string $inputString): string
    {
        return mb_convert_case($inputString, MB_CASE_LOWER, 'UTF-8');
    }

    public function clearNonAlphaNumericCharacters(string $inputString): string
    {
        $cleanedString = preg_replace('/[\W]/', '', $inputString);

        if ($cleanedString === null) {
            return $inputString;
        }

        return $cleanedString;
    }

    public function clearNonNumericCharacters(string $inputString): string
    {
        $cleanedString = preg_replace('/[^0-9]/', '', $inputString);

        if ($cleanedString === null) {
            return $inputString;
        }

        return $cleanedString;
    }

    /**
     * @param array<string, mixed> $rowData
     */
    public function isCellValueEmpty(array $rowData, string $column): bool
    {
        return false === isset($rowData[$column]) || '' === $rowData[$column];
    }

    /**
     * @param array<string, mixed> $rowData
     */
    public function getTrimmedString(array $rowData, string $column): string
    {
        return trim($rowData[$column]);
    }

    /**
     * @param array<string, mixed> $rowData
     */
    public function getNullableTrimmedString(array $rowData, string $column): ?string
    {
        if ($rowData[$column] === null) {
            return null;
        }

        return trim($rowData[$column]);
    }
}
