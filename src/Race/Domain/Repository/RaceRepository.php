<?php

declare(strict_types=1);

namespace App\Race\Domain\Repository;

use App\Race\Domain\Model\Race;
use App\Race\Domain\WriteModel\CreateRace as CreateRaceWriteModel;
use App\Race\Domain\WriteModel\UpdateRace as UpdateRaceWriteModel;

interface RaceRepository
{
    public function fetchOne(string $id): ?Race;

    public function add(CreateRaceWriteModel $race): Race;

    public function exists(string $title): bool;

    /** @return Race[] */
    public function fetchAll(): array;

    public function update(UpdateRaceWriteModel $race): Race;
}
