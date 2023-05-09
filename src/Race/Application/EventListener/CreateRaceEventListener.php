<?php

namespace App\Race\Application\EventListener;

use App\Race\Domain\Repository\RaceRepository;
use App\Shared\Application\Events\NewRaceImportedEvent;
use App\Shared\Application\EventStore\EventStore;

class CreateRaceEventListener
{
    public function __construct(
        private readonly RaceRepository $raceRepository,
        private readonly EventStore $eventStore
    ) {
    }

    public function onNewRaceImported(NewRaceImportedEvent $event): void
    {
        if (count($event->getVisitorAccommodationIds()) === 0) {
            return;
        }

        $visitorAccommodationIds = $event->getVisitorAccommodationIds();

        $unusedRetentions = $this->retentionRepository->findUnusedForAccommodationsBasedOn($visitorAccommodationIds);

        $visitorId = $this->visitorRepository->findIdForVisitorAccommodation($visitorAccommodationIds[0]);
        assert(is_string($visitorId) === true);

        $this->visitorRepository->markAsFinished($visitorId, $unusedRetentions);

        foreach ($unusedRetentions as $retentionId) {
            $this->eventStore->store(new RetentionFreedEvent($retentionId));
        }
    }
}
