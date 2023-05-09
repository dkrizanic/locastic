<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Bus\Query\Query;
use App\Shared\Application\Bus\Query\QueryBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonyQueryBus implements QueryBus
{
    public function __construct(private readonly MessageBusInterface $queryBus)
    {
    }

    public function getResult(Query $query): mixed
    {
        $envelope = $this->queryBus->dispatch($query);

        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);

        return $handled->getResult();
    }
}
