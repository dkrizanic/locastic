<?php

declare(strict_types=1);

namespace App\Shared\Domain\DTO;

trait ImportResultWithFailures
{
    /**
     * @var array<int, string>
     */
    private array $failures = [];

    public function addFailure(int $rowNumber, string $errorMessage): void
    {
        $this->failures[$rowNumber] = $errorMessage;
    }

    /**
     * @return array<int, string>
     */
    public function getFailures(): array
    {
        return $this->failures;
    }
}
