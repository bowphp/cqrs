<?php

namespace Bow\CQRS\Command;

use Bow\CQRS\Registration;
use Bow\CQRS\Command\CommandInterface;

class CommandBus
{
    /**
     * Execute the passed command
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function execute(CommandInterface $command): mixed
    {
        $handler = Registration::getHandler($command);

        return $handler->process($command);
    }
}
