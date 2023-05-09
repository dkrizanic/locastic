<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Command;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Stopwatch\Stopwatch;

trait CommandWithProgressBar
{
    use CommandWithInputOutput;

    protected ProgressBar $progressBar;
    protected Stopwatch $stopwatch;

    public function initializeBar(): void
    {
        $progressBar = new ProgressBar($this->output->section());

        $progressBar->setBarCharacter('<fg=cyan>~</>');
        $progressBar->setBarWidth(42);
        $progressBar->setProgressCharacter("\xF0\x9F\x90\x8C");

        $this->progressBar = $progressBar;
    }

    public function start(int $steps): void
    {
        $this->progressBar->setMaxSteps($steps);

        $this->stopwatch = new Stopwatch();
        $this->stopwatch->start('import-action');
    }

    public function advance(int $step = 1): void
    {
        $this->progressBar->advance($step);
    }

    public function finish(): void
    {
        $this->progressBar->finish();
        $stopwatchEvent = $this->stopwatch->stop('import-action');

        $this->output->writeln(sprintf('<fg=black;bg=green> %s</>', $stopwatchEvent));
    }
}
