<?php

declare(strict_types=1);

namespace App\Racer\Infrastructure\Command;

use App\Racer\Application\Importer\RacerImporter;
use App\Racer\Domain\DTO\RacerImportResultDTO;
use App\Racer\Domain\DTO\RacerImportSheetDataDTO;
use App\Shared\Application\Bus\Query\CheckIfRaceExists;
use App\Shared\Application\Bus\Query\QueryBus;
use App\Shared\Application\Helper\SpreadsheetInputSanitizer;
use App\Shared\Infrastructure\Command\ImportCommand;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImportRacerCommand extends ImportCommand
{
    use SpreadsheetInputSanitizer;

    protected static $defaultName = 'app:racer:import-race';
    protected const FILE_PATH_ARGUMENT = 'file_path';
    protected const RACE_TITLE = 'Race title';
    protected const RACE_DATE = 'Race date';

    public function __construct(
        private readonly RacerImporter $racerImporter,
        EntityManagerInterface $entityManager,
        ContainerInterface $container,
        private readonly QueryBus $queryBus,
    ) {
        parent::__construct($entityManager, $container);
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                self::FILE_PATH_ARGUMENT,
                InputArgument::REQUIRED,
                'A path to the readable file with race information'
            )
            ->addArgument(
                self::RACE_TITLE,
                InputArgument::REQUIRED,
                'Race title'
            )
            ->addArgument(
                self::RACE_DATE,
                InputArgument::REQUIRED,
                'Race date'
            )
            ->setDescription('Imports race based on rows in the referenced table')
            ->setHelp('This command allows you to import a batch of reservations from a structured Excel/CSV file');
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->initializeIO($input, $output);
        $this->racerImporter->setProgressAwareCommand($this);
        $this->racerImporter->setEntityManagerAwareCommand($this);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $filePath */
        $filePath = $input->getArgument(self::FILE_PATH_ARGUMENT);

        if (false === $this->isValidFilePath($filePath)) {
            $this->inputOutput->error('Valid path to the readable file must be provided.');

            return Command::FAILURE;
        }

        /** @var string $raceTitle */
        $raceTitle = $input->getArgument(self::RACE_TITLE);

        $raceExists = $this->queryBus->getResult(
            new CheckIfRaceExists($raceTitle)
        );

        if ($raceExists === true) {
            $this->inputOutput->error('Race already exists');
        }

        /** @var \DateTimeImmutable $raceDate */
        $raceDate = $input->getArgument(self::RACE_DATE);

        try {
            $spreadSheet = $this->loadSpreadSheet($filePath)->getActiveSheet();

            $this->inputOutput->success('Provided file is valid: ' . $filePath);

            // First row is expected to be a header row
            $firstHeaderRow = 1;
            $headerRowsCount = 1;

            $spreadSheet->removeRow($firstHeaderRow, $headerRowsCount);

            $dataDTO = new RacerImportSheetDataDTO(
                $spreadSheet->toArray(null, false, false, true),
                $headerRowsCount,
                $raceTitle,
                $raceDate
            );

            $this->initializeBar();
            $racerImportResultDTO = $this->racerImporter->import($dataDTO);
        } catch (\Throwable $exception) {
            $this->inputOutput->error(['Import failed.', $exception->getMessage()]);

            return Command::FAILURE;
        }

        $this->displayResults($racerImportResultDTO);

        return Command::SUCCESS;
    }

    private function displayResults(RacerImportResultDTO $racerImportResultDTO): void
    {
        $successOutputMessage = sprintf(
            "Racers imported: %d\n"
            . 'Skipped rows: %d',
            $racerImportResultDTO->racerImportsCount,
            $racerImportResultDTO->skippedRowsCount
        );
        $this->displayImportSuccess($successOutputMessage);
        $this->displayImportFailures($racerImportResultDTO->getFailures());
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function loadSpreadSheet(string $filePath): Spreadsheet
    {
        Cell::setValueBinder(new StringValueBinder());

        return IOFactory::load($filePath);
    }

    public function sortData():array
    {

    }
}
