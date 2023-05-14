<?php

namespace App\Race\Application\EventListener;

use App\Race\Domain\Repository\RaceRepository;
use App\Race\Domain\WriteModel\UpdateRace as UpdateRaceWriteModel;
use App\Shared\Application\Events\UpdateRaceAverageFinishTimeEvent;

class UpdateRaceAverageFinishTimeEventListener
{
    public function __construct(
        private readonly RaceRepository $raceRepository,
    ) {
    }

    public function onRaceAverageFinishTimeChange(UpdateRaceAverageFinishTimeEvent $event): void
    {
        $this->raceRepository->update(new UpdateRaceWriteModel(
            $event->getRaceId(),
            $event->getAverageFinishTimeMedium(),
            $event->getAverageFinishTimeLong(),
        ));
    }
}
