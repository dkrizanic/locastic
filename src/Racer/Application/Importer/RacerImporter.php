<?php

declare(strict_types=1);

namespace App\Racer\Application\Importer;

use App\Racer\Domain\DTO\RacerImportResultDTO;
use App\Racer\Domain\DTO\RacerImportSheetDataDTO;
use App\Racer\Domain\DTO\RacerImportSheetRowDataDTO;
use App\Racer\Domain\Repository\RacerRepository;
use App\Racer\Domain\WriteModel\CreateRacer as CreateRacerWriteModel;
use App\Shared\Application\Events\NewRaceImportedEvent;
use App\Shared\Application\EventStore\EventStore;
use App\Shared\Application\Factory\UuidGeneratorInterface;
use App\Shared\Application\Importer\EntityManagerResettableImporter;
use App\Shared\Application\Importer\ProgressibleImporter;

/**
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class RacerImporter
{
    use ProgressibleImporter;
    use EntityManagerResettableImporter;

    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly RacerRepository $raceRepository,
        private readonly EventStore $eventStore,
    ) {
    }

    public function import(
        RacerImportSheetDataDTO $dataDTO,
    ): RacerImportResultDTO {
        $racerImportResultDTO = new RacerImportResultDTO();

        $this->startProgress($dataDTO->getCount());

        $raceId = $this->uuidGenerator->generate();


        $this->createRace(
            $raceId,
            $dataDTO->getRaceTitle(),
            $dataDTO->getRaceDate(),
        );


        foreach ($dataDTO->getData() as $rowDataDTO) {
            try {
                $this->createRacer($raceId, $rowDataDTO, $racerImportResultDTO);
            } catch (\Throwable $exception) {
                $racerImportResultDTO->addFailure($rowDataDTO->getRowNumber(), $exception->getMessage());

                $this->reopenEntityManager();
            }

            $this->advanceProgress();

            // Increase EM reset interval
            $this->clearEntityManager();
        }

        $this->stopProgress();

        return $racerImportResultDTO;
    }

    private function createRacer(
        string $raceId,
        RacerImportSheetRowDataDTO $rowDataDTO,
        RacerImportResultDTO $resultDTO,
    ): void {
        if (true === $rowDataDTO->shouldSkipReservationCreation()) {
            ++$resultDTO->skippedRowsCount;

            throw new \Exception('Not all required cells have proper values in the table row');
        }

        $this->raceRepository->add($this->createRacerWriteModel($rowDataDTO, $raceId));

        ++$resultDTO->racerImportsCount;
    }

    private function createRace(
        string $id,
        string $title,
        \DateTimeImmutable $raceDate,
    ): void {
        $this->eventStore->store(new NewRaceImportedEvent($id, $title, $raceDate));
    }

    private function createRacerWriteModel(
        RacerImportSheetRowDataDTO $racerDataDTO,
        string $raceId,
    ): CreateRacerWriteModel {
        $uuid = $this->uuidGenerator->generate();

        return new CreateRacerWriteModel(
            $uuid,
            $racerDataDTO->getFullName(),
            $racerDataDTO->getDistance(),
            $racerDataDTO->getFinishTime(),
            $racerDataDTO->getAgeCategory(),
            $raceId
        );
    }
}
