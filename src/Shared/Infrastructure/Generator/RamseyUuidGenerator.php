<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Generator;

use App\Shared\Application\Factory\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
