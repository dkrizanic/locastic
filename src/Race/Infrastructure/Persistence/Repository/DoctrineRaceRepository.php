<?php

namespace App\Race\Infrastructure\Persistence\Repository;

use App\Entity\Race as DoctrineRace;
use App\Race\Domain\Model\Race;
use App\Race\Domain\Repository\RaceRepository;
use App\Race\Domain\WriteModel\CreateRace as CreateRaceWriteModel;
use App\Race\Domain\WriteModel\UpdateRace as UpdateRaceWriteModel;
use App\Race\Infrastructure\Persistence\Mapper\RaceMapper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class DoctrineRaceRepository implements RaceRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function fetchOne(string $id): ?Race
    {
        try {
            return RaceMapper::fromEntityToModel(
                $this->entityManager->createQueryBuilder()
                    ->select('r')
                    ->from(DoctrineRace::class, 'r')
                    ->where('r.id = :id')
                    ->setMaxResults(1)
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getSingleResult()
            );
        } catch (NoResultException) {
            return null;
        }
    }

    public function add(CreateRaceWriteModel $race): Race
    {
        $entity = new DoctrineRace(
            $race->id,
            $race->title,
            $race->dateTime,
            $race->averageFinishTimeMedium,
            $race->averageFinishTimeLong
        );

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return RaceMapper::fromEntityToModel($entity);
    }

    public function exists(string $title): bool
    {
        try {
            $this->entityManager->createQueryBuilder()
                ->select('1')
                ->from(DoctrineRace::class, 'r')
                ->where('r.title = :title')
                ->setParameter('title', $title)
                ->setMaxResults(1)
                ->getQuery()
                ->getSingleScalarResult();

            return true;
        } catch (NoResultException) {
            return false;
        }
    }

    /** @return Race[] */
    public function fetchAll(): array
    {
        $results = $this->entityManager->createQueryBuilder()
            ->select('r.id as id, r.title as title, r.dateTime as dateTime, r.averageFinishTimeMedium as averageFinishTimeMedium, r.averageFinishTimeLong as averageFinishTimeLong')
            ->from(DoctrineRace::class, 'r')
            ->getQuery()
            ->getResult();

        return array_map(static fn (array $row) => new Race(
            $row['id'],
            $row['title'],
            $row['dateTime'],
            sprintf('%02d:%02d:%02d', floor($row['averageFinishTimeMedium'] / 3600), floor($row['averageFinishTimeMedium'] / 60 % 60), floor($row['averageFinishTimeMedium'] % 60)),
            sprintf('%02d:%02d:%02d', floor($row['averageFinishTimeLong'] / 3600), floor($row['averageFinishTimeLong'] / 60 % 60), floor($row['averageFinishTimeLong'] % 60)),
        ), $results);
    }

    public function update(UpdateRaceWriteModel $race): Race
    {
        $entity = $this->entityManager->find(DoctrineRace::class, $race->id);
        assert($entity instanceof DoctrineRace);

        $entity->setAverageFinishTimeMedium($race->averageFinishTimeMedium);
        $entity->setAverageFinishTimeLong($race->averageFinishTimeLong);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return RaceMapper::fromEntityToModel($entity);
    }
}
