<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

interface EntityManagerAwareCommand
{
    public function clearManager(): void;

    public function reopenManager(): void;
}
