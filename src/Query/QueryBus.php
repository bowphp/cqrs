<?php

declare(strict_types=1);

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
        $query_handler = Registration::getHandler($query);

        return $query_handler->process($query);
    }
}
