<?php

namespace Bow\Tests\CQRS;

use Bow\CQRS\CQRSException;
use Bow\CQRS\Query\QueryBus;
use PHPUnit\Framework\TestCase;
use Bow\CQRS\Command\CommandBus;
use Bow\Tests\CQRS\Queries\FetchPetQuery;
use Bow\Tests\CQRS\Queries\FetchAllPetQuery;
use Bow\Tests\CQRS\Commands\CreatePetCommand;
use Bow\CQRS\Registration as CQRSRegistration;
use Bow\Tests\CQRS\Queries\FetchPetQueryHandler;
use Bow\Tests\CQRS\Commands\CreatePetCommandHandler;
use Bow\Tests\CQRS\Fixtures\PetFinder;

class CQRSTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        PetFinder::clear();

        CQRSRegistration::commands([
            CreatePetCommand::class => CreatePetCommandHandler::class
        ]);

        CQRSRegistration::queries([
            FetchPetQuery::class => FetchPetQueryHandler::class
        ]);
    }

    public function test_get_handler_should_return_the_right_handler()
    {
        $query_handler = CQRSRegistration::getHandler(new FetchPetQuery(1));
        $command_handler = CQRSRegistration::getHandler(new CreatePetCommand("Blaze", "Newt"));

        $this->assertInstanceOf(FetchPetQueryHandler::class, $query_handler);
        $this->assertInstanceOf(CreatePetCommandHandler::class, $command_handler);
    }

    public function test_get_handler_should_throw_error()
    {
        $this->expectException(CQRSException::class);

        CQRSRegistration::getHandler(new FetchAllPetQuery());
    }

    public function test_command_bus()
    {
        $command_bus = new CommandBus();
        $id = $command_bus->execute(new CreatePetCommand("Pascal", "Franck"));

        $this->assertEquals($id, 1);
    }

    public function test_query_bus()
    {
        $query_bus = new QueryBus();
        $pet = $query_bus->execute(new FetchPetQuery(1));

        $this->assertEquals($pet->name, 'Pascal');
    }
}
