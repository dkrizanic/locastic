<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Command;

use App\Shared\Application\Command\EntityManagerAwareCommand;
use App\Shared\Application\Command\ProgressAwareCommand;
use Doctrine\Bundle\DoctrineBundle\Registry as DoctrineRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ImportCommand extends Command implements ProgressAwareCommand, EntityManagerAwareCommand
{
    use CommandWithProgressBar;
    use CommandWithEntityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly ContainerInterface $container,
    ) {
        parent::__construct();

        /** @var DoctrineRegistry $doctrineRegistry */
        $doctrineRegistry = $this->container->get('doctrine');

        $this->initializeEntityManager($entityManager, $doctrineRegistry);
    }
}
