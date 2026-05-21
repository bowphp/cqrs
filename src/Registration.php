<?php

declare(strict_types=1);

namespace Bow\CQRS;

use Bow\CQRS\Attribute\CommandHandler as CommandHandlerAttribute;
use Bow\CQRS\Attribute\QueryHandler as QueryHandlerAttribute;
use Bow\CQRS\CQRSException;
use Bow\CQRS\Query\QueryInterface;
use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Query\QueryHandlerInterface;
use Bow\CQRS\Command\CommandHandlerInterface;
use ReflectionClass;

final class Registration
{
    /**
     * Define the registra commands
     *
     * @var array
     */
    private static array $commands = [];

    /**
     * Define the registra queries
     *
     * @var array
     */
    private static array $queries = [];

    /**
     * Get the registra queries
     *
     * @param array $queries
     * @return void
     */
    public static function queries(array $queries): void
    {
        static::$queries = [...static::$queries, ...$queries];
    }

    /**
     * Get the registra command
     *
     * @param array $commands
     * @return void
     */
    public static function commands(array $commands): void
    {
        static::$commands = [...static::$commands, ...$commands];
    }

    /**
     * Register handlers declared with attributes.
     *
     * @param array $handlers
     * @return void
     */
    public static function handlers(array $handlers): void
    {
        foreach ($handlers as $handler) {
            static::registerHandler($handler);
        }
    }

    /**
     * Register a handler declared with attributes.
     *
     * @param string $handler
     * @return void
     */
    private static function registerHandler(string $handler): void
    {
        $reflection = new ReflectionClass($handler);

        $commandAttributes = $reflection->getAttributes(CommandHandlerAttribute::class);
        $queryAttributes = $reflection->getAttributes(QueryHandlerAttribute::class);

        if (count($commandAttributes) === 0 && count($queryAttributes) === 0) {
            throw new CQRSException(
                sprintf(
                    "The handler %s has no #[CommandHandler] or #[QueryHandler] attribute",
                    $handler
                )
            );
        }

        foreach ($commandAttributes as $attribute) {
            $commandHandler = $attribute->newInstance();
            static::$commands[$commandHandler->getCommandClass()] = $handler;
        }

        foreach ($queryAttributes as $attribute) {
            $queryHandler = $attribute->newInstance();
            static::$queries[$queryHandler->getQueryClass()] = $handler;
        }
    }

    /**
     * Reset the registered commands and queries.
     *
     * Mostly useful in tests to isolate state between cases.
     *
     * @return void
     */
    public static function reset(): void
    {
        static::$commands = [];
        static::$queries = [];
    }

    /**
     * Get the registra command or query
     *
     * @param QueryInterface|CommandInterface $cq
     * @return QueryHandlerInterface|CommandHandlerInterface
     */
    public static function getHandler(
        QueryInterface|CommandInterface $cq
    ): QueryHandlerInterface|CommandHandlerInterface {
        if ($cq instanceof CommandInterface) {
            return static::getCommandHandler($cq);
        }

        return static::getQueryHandler($cq);
    }

    /**
     * Get the command handler for the given command instance.
     *
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     */
    public static function getCommandHandler(
        CommandInterface $command
    ): CommandHandlerInterface {
        $command_class = get_class($command);

        $handler = static::$commands[$command_class] ?? null;

        if (!is_null($handler)) {
            return static::makeHandler($handler);
        }

        throw new CQRSException(
            sprintf(
                "The command %s handler is not found on the CQ register",
                $command_class
            )
        );
    }

    /**
     * Get the query handler for the given query instance.
     *
     * @param QueryInterface $query
     * @return QueryHandlerInterface
     */
    public static function getQueryHandler(
        QueryInterface $query
    ): QueryHandlerInterface {
        $query_class = get_class($query);

        $handler = static::$queries[$query_class] ?? null;

        if (!is_null($handler)) {
            return static::makeHandler($handler);
        }

        throw new CQRSException(
            sprintf(
                "The query %s handler is not found on the CQ register",
                $query_class
            )
        );
    }

    /**
     * Resolve handler from container or instantiate directly.
     *
     * @param string $handler
     * @return QueryHandlerInterface|CommandHandlerInterface
     */
    private static function makeHandler(
        string $handler
    ): QueryHandlerInterface|CommandHandlerInterface {
        if (function_exists('app')) {
            return app($handler);
        }

        return new $handler();
    }
}
