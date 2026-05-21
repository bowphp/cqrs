<?php

namespace Bow\Tests\CQRS\Queries;

use Bow\CQRS\Attribute\QueryHandler;
use Bow\CQRS\Query\QueryHandlerInterface;
use Bow\CQRS\Query\QueryInterface;

#[QueryHandler(InlineFetchAllQuery::class)]
class InlineFetchAllQueryHandler implements QueryHandlerInterface
{
    public function process(QueryInterface $query): string
    {
        return 'ok';
    }
}
