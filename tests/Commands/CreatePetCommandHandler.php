<?php

namespace Bow\Tests\CQRS\Commands;

use Bow\Tests\CQRS\Fixtures\PetFinder;
use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Command\CommandHandlerInterface;

class CreatePetCommandHandler implements CommandHandlerInterface
{
    public function process(CommandInterface $command): int
    {
        $petId = PetFinder::create([
            "name" => $command->name,
            "author" => $command->author
        ]);

        return $petId;
    }
}
