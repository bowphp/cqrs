<?php

namespace Bow\Tests\CQRS\Commands;

use Bow\Tests\Database\Stubs\PetModelStub;
use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Command\CommandHandlerInterface;
use Bow\Tests\CQRS\Commands\CreatePetCommand;

class CreatePetCommandHandler implements CommandHandlerInterface
{
    public function process(CommandInterface $command): mixed
    {
        $pet = PetModelStub::create([
            "name" => $command->name,
        ]);

        return $pet->id;
    }
}
