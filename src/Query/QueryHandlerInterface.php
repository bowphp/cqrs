<?php

namespace Bow\CQRS\Query;

use Bow\CQRS\Query\QueryInterface;

interface QueryHandlerInterface
{
    /**
     * Handle the query
     *
     * @param QueryInterface $query
     * @return mixed
     */
    public function process(QueryInterface $query): mixed;
}
