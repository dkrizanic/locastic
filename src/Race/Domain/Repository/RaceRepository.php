<?php

declare(strict_types=1);

namespace App\Race\Domain\Repository;

use App\Race\Domain\Model\Race;
use App\Race\Domain\WriteModel\CreateRace as CreateRaceWriteModel;

interface RaceRepository
{
    public function fetchOneByTitle(string $title): ?Race;

    public function add(CreateRaceWriteModel $race): Race;

    public function exists(string $title): bool;

    /** @return Race[] */
    public function fetchAll(): array;
}
