<?php

declare(strict_types=1);

namespace App\Shared\Domain\DTO;

use App\Shared\Domain\Helper\SheetRowDataHelper;

class SheetRowDataDTO
{
    use SheetRowDataHelper;

    /**
     * @param array<string, mixed> $rowData
     */
    public function __construct(
        protected readonly array $rowData,
        protected readonly int $rowNumber,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->rowData;
    }

    public function getRowNumber(): int
    {
        return $this->rowNumber;
    }
}
