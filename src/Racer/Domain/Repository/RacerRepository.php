<?php

declare(strict_types=1);

namespace App\Racer\Domain\Repository;

use App\Racer\Domain\Model\Racer;
use App\Racer\Domain\WriteModel\CreateRacer as CreateRacerWriteModel;

interface RacerRepository
{
    public function add(CreateRacerWriteModel $racer): Racer;
}
