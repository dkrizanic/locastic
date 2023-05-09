<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;

trait CommandWithEntityManager
{
    protected EntityManagerInterface $entityManager;
    protected Registry $doctrineRegistry;

    public function initializeEntityManager(EntityManagerInterface $entityManager, Registry $registry): void
    {
        $this->entityManager = $entityManager;
        $this->doctrineRegistry = $registry;
        // Small optimization to reduce memory usage - set logger to null
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger();
    }

    public function clearManager(): void
    {
        $this->entityManager->clear();
    }

    public function reopenManager(): void
    {
        $entityManager = $this->doctrineRegistry->getManager();
        assert($entityManager instanceof EntityManagerInterface);

        if (true === $entityManager->isOpen()) {
            return;
        }

        $this->doctrineRegistry->resetManager();
    }
}
