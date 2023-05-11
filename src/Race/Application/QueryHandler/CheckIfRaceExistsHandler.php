<?php

declare(strict_types=1);

namespace App\Race\Application\QueryHandler;

use App\Race\Domain\Repository\RaceRepository;
use App\Shared\Application\Bus\Query\CheckIfRaceExists;
use App\Shared\Application\Bus\Query\QueryHandler;

class CheckIfRaceExistsHandler implements QueryHandler
{
    public function __construct(private readonly RaceRepository $raceRepository)
    {
    }

    public function __invoke(CheckIfRaceExists $query): bool
    {
        return $this->raceRepository->exists($query->title);
    }
}
