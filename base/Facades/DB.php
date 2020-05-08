<?php

namespace Base\Facades;

use Base\Api\DatabaseAdapterInterface;

/**
 * Class DB
 *
 * Facade class for the database adapter.
 *
 * @package Base\Facades
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see DatabaseAdapterInterface
 *
 * @method static mixed executeRaw(string $statement) Execute a raw query.
 * @method static void beginTransaction() Begin a new database transaction.
 * @method static void commit() Commit the active transaction.
 * @method static void rollback() Roll back the active transaction.
 * @method static mixed runInTransaction(callable $statements) Executes the given function in a single database transaction. Rolls back in case of error. If an error/exception is caught, it is thrown again after the transaction rolls back.
 * @method static void create(string $table, array $values) Create a new entry in the given table, with the given values.
 * @method static void update(string $table, array $values, array $where = []) Update the entries that match the query parameters passed to this method, with the given values.
 * @method static void delete(string $table, array $where = [])  Delete the entries that match the query parameters passed to this method.
 * @method static array read(string $table, array $select = ['*'], array $where = []) Query the given table for rows matching the query parameters passed to this method. Retrieve only the columns passed in the $select array.
 */
final class DB extends Facade
{
    /**
     * Class/DI tag that should be accessed by the Facade using static methods.
     */
    public const FACADE_ACCESSOR = DatabaseAdapterInterface::class;
}