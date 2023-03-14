<?php

namespace Bow\Tests\CQRS\Queries;

use Bow\CQRS\Query\QueryInterface;

class FetchPetQuery implements QueryInterface
{
    public function __construct(public int $id)
    {
    }
}
