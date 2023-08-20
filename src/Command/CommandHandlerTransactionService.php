<?php

namespace Bow\CQRS\Command;

use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Command\CommandHandlerInterface;
use Bow\Database\Database;
use Bow\Database\Exception\DatabaseException;

abstract class CommandHandlerTransactionService implements CommandHandlerInterface
{
    /**
    * @param CommandInterface $command
    * @return mixed
    */
    abstract protected function run(CommandInterface $command): mixed;

    /**
     * @inheritDoc
     */
    public function process(CommandInterface $command): mixed
    {
        Database::startTransaction();

        try {
            $result = $this->run($command);

            Database::commit();

            return $result;
        } catch (DatabaseException $e) {
            Database::rollback();
            throw $e;
        }
    }
}
