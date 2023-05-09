<?php

declare(strict_types=1);

namespace App\Shared\Application\Importer;

use App\Shared\Application\Command\ProgressAwareCommand;

trait ProgressibleImporter
{
    private ProgressAwareCommand $progressAwareCommand;

    public function setProgressAwareCommand(ProgressAwareCommand $command): void
    {
        $this->progressAwareCommand = $command;
    }

    public function startProgress(int $steps): void
    {
        $this->progressAwareCommand->start($steps);
    }

    public function advanceProgress(): void
    {
        $this->progressAwareCommand->advance();
    }

    public function stopProgress(): void
    {
        $this->progressAwareCommand->finish();
    }
}
