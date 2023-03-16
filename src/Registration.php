<?php

declare(strict_types=1);

namespace Bow\CQRS;

use Bow\CQRS\CQRSException;
use Bow\CQRS\Query\QueryInterface;
use Bow\CQRS\Command\CommandInterface;
use Bow\CQRS\Query\QueryHandlerInterface;
use Bow\CQRS\Command\CommandHandlerInterface;

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
        static::$queries = $queries;
    }

    /**
     * Get the registra command
     *
     * @param array $commands
     * @return void
     */
    public static function commands(array $commands): void
    {
        static::$commands = $commands;
    }

    /**
     * Get the registra command or query
     *
     * @param QueryInterface|CommandInterface $cq
     * @return QueryHandlerInterface|CommandHandlerInterface
     */
    public static function getHandler(
        QueryInterface|CommandInterface $action
    ): QueryHandlerInterface|CommandHandlerInterface {
        $action_class = get_class($action);

        if ($action instanceof QueryInterface) {
            $handler = static::$queries[$action_class] ?? null;
        } else {
            $handler = static::$commands[$action_class] ?? null;
        }

        if (!is_null($handler)) {
            return app($handler);
        }

        throw new CQRSException(
            sprintf(
                "The %s %s:class handler is not found on the CQ register",
                $action instanceof QueryInterface ? 'query' : 'command',
                $action_class
            )
        );
    }
}
