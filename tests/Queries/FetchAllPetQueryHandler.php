<?php

namespace Bow\Tests\CQRS\Queries;

use Bow\CQRS\Attribute\QueryHandler;
use Bow\Tests\CQRS\Fixtures\PetFinder;
use Bow\CQRS\Query\QueryInterface;
use Bow\CQRS\Query\QueryHandlerInterface;

#[QueryHandler(FetchAllPetQuery::class)]
class FetchAllPetQueryHandler implements QueryHandlerInterface
{
    public function process(QueryInterface $query): mixed
    {
        $pets = PetFinder::all();

        foreach ($pets as $key => $pet) {
            $pets[$key] = (object) $pet;
        }

        return $pets;
    }
}
