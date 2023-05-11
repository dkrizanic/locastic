<?php

namespace App\Race\Application\EventListener;

use App\Race\Domain\Repository\RaceRepository;
use App\Race\Domain\WriteModel\CreateRace;
use App\Shared\Application\Events\NewRaceImportedEvent;

class CreateRaceEventListener
{
    public function __construct(
        private readonly RaceRepository $raceRepository,
    ) {
    }

    public function onNewRaceImported(NewRaceImportedEvent $event): void
    {
        $this->raceRepository->add(new CreateRace(
            $event->getRaceId(),
            $event->getRaceTitle(),
            $event->getRaceDate(),
        ));
    }
}
