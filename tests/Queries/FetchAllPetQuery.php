<?php

namespace Bow\Tests\CQRS\Queries;

use Bow\CQRS\Query\QueryInterface;

class FetchAllPetQuery implements QueryInterface
{
    public function __construct()
    {
    }
}
