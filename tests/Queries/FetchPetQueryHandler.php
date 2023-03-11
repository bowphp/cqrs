<?php

use Bow\Test\Fixtures\PetFinder;
use Bow\CQRS\Query\QueryInterface;
use Bow\CQRS\Query\QueryHandlerInterface;

class FetchPetQueryHandler implements QueryHandlerInterface
{
    public function process(QueryInterface $query): mixed
    {
        $pet = PetFinder::find($query->id);

        return $pet;
    }
}
