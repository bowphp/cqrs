<?php

namespace Bow\Tests\CQRS\Queries;

use Bow\CQRS\Attribute\QueryHandler;
use Bow\Tests\CQRS\Fixtures\PetFinder;
use Bow\CQRS\Query\QueryInterface;
use Bow\CQRS\Query\QueryHandlerInterface;

#[QueryHandler(FetchPetQuery::class)]
class FetchPetQueryHandler implements QueryHandlerInterface
{
    public function process(QueryInterface $query): mixed
    {
        $pet = PetFinder::find($query->id);

        return $pet;
    }
}
