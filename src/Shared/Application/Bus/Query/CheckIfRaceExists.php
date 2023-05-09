<?php

namespace App\Shared\Application\Bus\Query;

class CheckIfRaceExists implements Query
{
    public function __construct(public string $title)
    {
    }
}
