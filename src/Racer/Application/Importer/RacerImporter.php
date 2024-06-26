<?php

declare(strict_types=1);

namespace App\Racer\Application\Importer;

use App\Racer\Domain\DTO\RacerImportResultDTO;
use App\Racer\Domain\DTO\RacerImportSheetDataDTO;
use App\Racer\Domain\DTO\RacerImportSheetRowDataDTO;
use App\Racer\Domain\Repository\RacerRepository;
use App\Racer\Domain\WriteModel\CreateRacer as CreateRacerWriteModel;
use App\Shared\Application\Events\NewRaceImportedEvent;
use App\Shared\Application\Events\UpdateRaceAverageFinishTimeEvent;
use App\Shared\Application\EventStore\EventStore;
use App\Shared\Application\Factory\UuidGeneratorInterface;
use App\Shared\Application\Importer\EntityManagerResettableImporter;
use App\Shared\Application\Importer\ProgressableImporter;

/**
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class RacerImporter
{
    use ProgressableImporter;
    use EntityManagerResettableImporter;

    private int $racerInFrontFinishTime = 0;

    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly RacerRepository $racerRepository,
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
            0,
            0
        );

        $overallPlacement = 0;
        $countOfLongDistanceRacers = 0;
        $countOfMediumDistanceRacers = 0;
        $combinedFinishTimeForLongDistanceRace = 0;
        $combinedFinishTimeForMediumDistanceRace = 0;
        $rowDataDTOs = [];
        foreach ($dataDTO->getData() as $rowDataDTO) {
            try {
                $finishTime = $rowDataDTO->getFinishTime();
                if ($rowDataDTO->getDistance() === 'long') {
                    ++$countOfLongDistanceRacers;
                    $combinedFinishTimeForLongDistanceRace = +$finishTime;
                    if ($this->racerInFrontFinishTime !== $finishTime) {
                        ++$overallPlacement;
                        $incrementAgeCategoryPlacement = 1;
                    } else {
                        $incrementAgeCategoryPlacement = 0;
                    }
                    $placement = $overallPlacement;

                    $rowDataDTOKey = sprintf('%s', $rowDataDTO->getAgeCategory());
                    if (!array_key_exists($rowDataDTOKey, $rowDataDTOs)) {
                        $rowDataDTOs[$rowDataDTOKey] = 1;
                    } else {
                        $rowDataDTOs[$rowDataDTOKey] = $rowDataDTOs[$rowDataDTOKey] + $incrementAgeCategoryPlacement;
                    }

                    $ageCategoryPlacement = $rowDataDTOs[$rowDataDTOKey];
                } else {
                    $placement = null;
                    $ageCategoryPlacement = null;
                    $combinedFinishTimeForMediumDistanceRace = +$finishTime;
                    ++$countOfMediumDistanceRacers;
                }

                $this->createRacer($raceId, $rowDataDTO, $racerImportResultDTO, $placement, $ageCategoryPlacement);

                $this->racerInFrontFinishTime = $rowDataDTO->getFinishTime();
            } catch (\Throwable $exception) {
                $racerImportResultDTO->addFailure($rowDataDTO->getRowNumber(), $exception->getMessage());

                $this->reopenEntityManager();
            }

            $this->advanceProgress();

            // Increase EM reset interval
            $this->clearEntityManager();
        }

        $this->updateRaceAverageFinishTime(
            $raceId,
            (int) round($combinedFinishTimeForMediumDistanceRace / $countOfMediumDistanceRacers),
            (int) round($combinedFinishTimeForLongDistanceRace / $countOfLongDistanceRacers)
        );

        $this->stopProgress();

        return $racerImportResultDTO;
    }

    private function createRacer(
        string $raceId,
        RacerImportSheetRowDataDTO $rowDataDTO,
        RacerImportResultDTO $resultDTO,
        ?int $overallPlacement,
        ?int $ageCategoryPlacement,
    ): void {
        if (true === $rowDataDTO->shouldSkipReservationCreation()) {
            ++$resultDTO->skippedRowsCount;

            throw new \Exception('Not all required cells have proper values in the table row');
        }

        $this->racerRepository->add($this->createRacerWriteModel($rowDataDTO, $raceId, $overallPlacement, $ageCategoryPlacement));

        ++$resultDTO->racerImportsCount;
    }

    private function createRace(
        string $id,
        string $title,
        \DateTime $raceDate,
        int $averageFinishTimeMedium,
        int $averageFinishTimeLong,
    ): void {
        $this->eventStore->store(new NewRaceImportedEvent($id, $title, $raceDate, $averageFinishTimeMedium, $averageFinishTimeLong));
    }

    private function updateRaceAverageFinishTime(
        string $id,
        int $averageFinishTimeMedium,
        int $averageFinishTimeLong,
    ): void {
        $this->eventStore->store(new UpdateRaceAverageFinishTimeEvent($id, $averageFinishTimeMedium, $averageFinishTimeLong));
    }

    private function createRacerWriteModel(
        RacerImportSheetRowDataDTO $racerDataDTO,
        string $raceId,
        ?int $overallPlacement,
        ?int $ageCategoryPlacement
    ): CreateRacerWriteModel {
        $uuid = $this->uuidGenerator->generate();

        return new CreateRacerWriteModel(
            $uuid,
            $racerDataDTO->getFullName(),
            $racerDataDTO->getDistance(),
            $racerDataDTO->getFinishTime(),
            $racerDataDTO->getAgeCategory(),
            $raceId,
            $overallPlacement,
            $ageCategoryPlacement,
        );
    }
}
