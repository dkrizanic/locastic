<?php

namespace App\Racer\Infrastructure\Persistence\Mapper;

use App\Entity\Racer as DoctrineRacer;
use App\Racer\Domain\Model\Racer;

class RacerMapper
{
    public static function fromEntityToModel(DoctrineRacer $racerEntity): Racer
    {
        $domainObject = new Racer(
            $racerEntity->getId(),
            $racerEntity->getFullName(),
            $racerEntity->getFinishTime(),
            $racerEntity->getDistance(),
            $racerEntity->getAgeCategory(),
            $racerEntity->getRace(),
        );

        $domainObject->setOverallPlacement($racerEntity->getOverallPlacement());
        $domainObject->setAgeCategoryPlacement($racerEntity->getAgeCategoryPlacement());

        return $domainObject;
    }
}
