<?php

namespace App\Race\Infrastructure\Persistence\Repository;

use App\Entity\Race as DoctrineRace;
use App\Race\Domain\Model\Race;
use App\Race\Domain\Repository\RaceRepository;
use App\Race\Domain\WriteModel\CreateRace as CreateRaceWriteModel;
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

    public function fetchOneByTitle(string $title): ?Race
    {
        try {
            return RaceMapper::fromEntityToModel(
                $this->entityManager->createQueryBuilder()
                    ->select('r')
                    ->from(DoctrineRace::class, 'r')
                    ->where('p.title = :title')
                    ->setMaxResults(1)
                    ->setParameter('title', $title)
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
            $race->dateTime
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
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('v')
            ->from(DoctrineRace::class, 'r');

        return array_map(
            [RaceMapper::class, 'fromEntityToModel'],
            $queryBuilder->getQuery()->getResult()
        );
    }
}
