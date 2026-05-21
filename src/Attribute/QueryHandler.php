<?php

declare(strict_types=1);

namespace Bow\CQRS\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class QueryHandler
{
    public function __construct(
        private readonly string $queryClass
    ) {
    }

    public function getQueryClass(): string
    {
        return $this->queryClass;
    }
}
