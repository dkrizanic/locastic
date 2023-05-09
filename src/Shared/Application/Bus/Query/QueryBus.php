<?php

namespace App\Shared\Application\Bus\Query;

interface QueryBus
{
    public function getResult(Query $query): mixed;
}
