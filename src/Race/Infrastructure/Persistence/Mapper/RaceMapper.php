<?php

namespace App\Race\Infrastructure\Persistence\Mapper;

use App\Entity\Race as DoctrineRace;
use App\Race\Domain\Model\Race;

class RaceMapper
{
    public static function fromEntityToModel(DoctrineRace $raceEntity): Race
    {
        return new Race(
            $raceEntity->getId(),
            $raceEntity->getTitle(),
            $raceEntity->getDateTime()
        );
    }
}
