<?php

declare(strict_types=1);

namespace App\Shared\Application\Factory;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
