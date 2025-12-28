<?php

namespace Bow\Tests\CQRS\Commands;

use Bow\CQRS\Attribute\CommandHandler;
use Bow\CQRS\Command\CommandHandlerInterface;
use Bow\CQRS\Command\CommandInterface;

#[CommandHandler(DummyCreateUserCommand::class)]
class DummyCreateUserCommandHandler implements CommandHandlerInterface
{
    public function process(CommandInterface $command): string
    {
        return 'created ' . $command->name;
    }
}
