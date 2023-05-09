<?php

namespace App\Racer\Infrastructure\Persistence\Repository;

use App\Entity\Racer as DoctrineRacer;
use App\Racer\Domain\Model\Racer;
use App\Racer\Domain\Repository\RacerRepository;
use App\Racer\Domain\WriteModel\CreateRacer as CreateRacerWriteModel;
use App\Racer\Infrastructure\Persistence\Mapper\RacerMapper;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class DoctrineRacerRepository implements RacerRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function add(CreateRacerWriteModel $racer): Racer
    {
        $entity = new DoctrineRacer(
            $racer->id,
            $racer->fullName,
            $racer->finishTime,
            $racer->distance,
            $racer->ageCategory,
            $racer->raceId,
        );

        $entity->setOverallPlacement($racer->overallPlacement);
        $entity->setAgeCategoryPlacement($racer->ageCategoryPlacement);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return RacerMapper::fromEntityToModel($entity);
    }
}
