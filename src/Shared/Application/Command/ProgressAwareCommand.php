<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

interface ProgressAwareCommand
{
    public function start(int $steps): void;

    public function advance(int $step = 1): void;

    public function finish(): void;
}
