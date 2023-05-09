<?php

declare(strict_types=1);

namespace App\Shared\Application\Importer;

use App\Shared\Application\Command\EntityManagerAwareCommand;

trait EntityManagerResettableImporter
{
    private EntityManagerAwareCommand $entityManagerAwareCommand;

    public function setEntityManagerAwareCommand(EntityManagerAwareCommand $command): void
    {
        $this->entityManagerAwareCommand = $command;
    }

    public function clearEntityManager(): void
    {
        $this->entityManagerAwareCommand->clearManager();
    }

    public function reopenEntityManager(): void
    {
        $this->entityManagerAwareCommand->reopenManager();
    }
}
