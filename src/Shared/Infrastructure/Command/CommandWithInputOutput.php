<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait CommandWithInputOutput
{
    protected SymfonyStyle $inputOutput;
    protected ConsoleOutputInterface $output;

    public function initializeIO(InputInterface $input, OutputInterface $output): void
    {
        assert($output instanceof ConsoleOutputInterface);
        $this->output = $output;

        $this->inputOutput = new SymfonyStyle($input, $output);
    }

    public function displayImportSuccess(string $outputMessage): void
    {
        $this->inputOutput->success($outputMessage);
    }

    /**
     * @param array<int, string> $failures
     */
    public function displayImportFailures(array $failures): void
    {
        if (0 === count($failures)) {
            return;
        }

        $failureOutputMessage = 'Import failed for some rows';
        $composedErrors = array_map(
            fn (int $rowNumber, string $errorMessage) => sprintf('Row: [%d], %s', $rowNumber, $errorMessage),
            array_keys($failures),
            $failures
        );

        $this->inputOutput->error(array_merge(
            [$failureOutputMessage],
            [implode("\n", $composedErrors)]
        ));
    }

    /**
     * @param array<int, string> $warnings
     */
    public function displayImportWarnings(array $warnings): void
    {
        if (0 === count($warnings)) {
            return;
        }

        $composedWarnings = array_map(
            fn (int $rowNumber, string $message) => sprintf('Row: [%d], %s', $rowNumber, $message),
            array_keys($warnings),
            $warnings
        );

        $this->inputOutput->warning(implode("\n", $composedWarnings));
    }
}
