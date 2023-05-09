<?php

declare(strict_types=1);

namespace App\CheckIn\Application\Manager;

use App\Shared\Application\Factory\UuidGeneratorInterface;

class RacerManager
{
    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator
    ) {
    }

    /**
     * @param array<string, mixed> $rawPayload
     */
    public function archive(array $rawPayload): void
    {
    }
}
