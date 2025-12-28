<?php

declare(strict_types=1);

namespace Bow\CQRS\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class CommandHandler
{
    public function __construct(
        private readonly string $commandClass
    ) {
    }

    public function getCommandClass(): string
    {
        return $this->commandClass;
    }
}
