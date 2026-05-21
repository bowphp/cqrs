<?php

namespace Bow\Tests\CQRS\Commands;

use Bow\CQRS\Command\CommandInterface;

class DummyCreateUserCommand implements CommandInterface
{
    public function __construct(public string $name)
    {
    }
}
