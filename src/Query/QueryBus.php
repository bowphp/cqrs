<?php

namespace Bow\CQRS\Query;

use Bow\CQRS\Registration;

class QueryBus
{
    /**
     * Execute the query now
     *
     * @param QueryInterface $query
     * @return mixed
     */
    public function execute(QueryInterface $query): mixed
    {
        $handler = Registration::getHandler($query);

        return $handler->process($query);
    }
}
