<?php

declare(strict_types=1);

namespace App\Racer\Domain\DTO;

use App\Shared\Domain\DTO\ImportResultWithFailures;

class RacerImportResultDTO
{
    use ImportResultWithFailures;

    public int $racerImportsCount = 0;
    public int $skippedRowsCount = 0;
}
