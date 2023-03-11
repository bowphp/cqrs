<?php

namespace Bow\CQRS\Command;

use Bow\CQRS\Command\CommandInterface;

interface CommandHandlerInterface
{
    /**
     * Handle the command
     *
     * @param CommandInterface $command
     * @return mixed
     */
    public function process(CommandInterface $command): mixed;
}
