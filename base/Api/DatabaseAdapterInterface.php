<?php

namespace Base\Api;

/**
 * Interface DatabaseAdapterInterface
 * @package Base\Api
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface DatabaseAdapterInterface
{
    /**
     * Execute a raw query.
     *
     * @param string $statement
     * @return mixed
     */
    public function executeRaw(string $statement);

    /**
     * Begin a new database transaction.
     */
    public function beginTransaction(): void;

    /**
     * Commit the active transaction.
     */
    public function commit(): void;

    /**
     * Roll back the active transaction.
     */
    public function rollback(): void;

    /**
     * Executes the given function in a single database transaction.
     * Rolls back in case of error.
     * If an error/exception is caught, it is thrown again after the
     * transaction rolls back.
     *
     * @param callable $statements The function to execute in a single transaction.
     * @return mixed Returns the result from the given callable.
     */
    public function runInTransaction(callable $statements);

    /**
     * Create a new entry in the given table, with the given values.
     *
     * @param string $table The table to insert a new row into.
     * @param array $values The values to insert (Associative array with column names as keys).
     */
    public function create(string $table, array $values): void;

    /**
     * Update the entries that match the query parameters
     * passed to this method, with the given values.
     *
     * @param string $table The table to query and update rows.
     * @param array $values The values to update (Associative array with column names as keys).
     * @param array $where Query parameters.
     *
     * Query syntax:
     *
     * [
     *
     *     "column_name" =>
     *     [
     *         "in|nin|like|gt|ge|lt|le|eq" => ["value", ...]
     *     ]
     *
     * ]
     *
     * in: Query for data IN the values provided. (Pass array of values as value)
     *
     * nin: Query for data NOT IN the values provided. (Pass array as value)
     *
     * like: Query for data LIKE the value provided (Pass string as value).
     *
     * nlike: Query for data NOT LIKE the value provided (Pass string as value).
     *
     * gt: Query for data GREATER THAN the value provided (Pass string as value).
     *
     * ge: Query for data GREATER THAN OR EQUAL TO the value provided (Pass string as value).
     *
     * lt: Query for data LESS THAN the value provided (Pass string as value).
     *
     * le: Query for data LESS THAN OR EQUAL TO the value provided (Pass string as value).
     *
     * eq: Query for data EQUAL TO the value provided (Pass string as value).
     *
     * neq: Query for data NOT EQUAL TO the value provided (Pass string as value).
     *
     */
    public function update(string $table, array $values, array $where = []): void;

    /**
     * Delete the entries that match the query parameters
     * passed to this method.
     *
     * @param string $table The table to query and delete rows.
     * @param array $where Query parameters.
     *
     * Query syntax:
     *
     * [
     *
     *     "column_name" =>
     *     [
     *         "in|nin|like|gt|ge|lt|le|eq" => ["value", ...],
     *         "and" => true|false (Optional property, true by default)
     *     ]
     *
     * ]
     *
     * in: Query for data IN the values provided. (Pass array of values as value)
     *
     * nin: Query for data NOT IN the values provided. (Pass array as value)
     *
     * like: Query for data LIKE the value provided (Pass string as value).
     *
     * nlike: Query for data NOT LIKE the value provided (Pass string as value).
     *
     * gt: Query for data GREATER THAN the value provided (Pass string as value).
     *
     * ge: Query for data GREATER THAN OR EQUAL TO the value provided (Pass string as value).
     *
     * lt: Query for data LESS THAN the value provided (Pass string as value).
     *
     * le: Query for data LESS THAN OR EQUAL TO the value provided (Pass string as value).
     *
     * eq: Query for data EQUAL TO the value provided (Pass string as value).
     *
     * neq: Query for data NOT EQUAL TO the value provided (Pass string as value).
     *
     */
    public function delete(string $table, array $where = []): void;

    /**
     * Query the given table for rows matching the query parameters
     * passed to this method. Retrieve only the columns passed in the $select array.
     *
     * @param string $table The table to query.
     * @param string[] $select The columns to select from every row.
     * @param array $where Query parameters.
     *
     * Query syntax:
     *
     * [
     *
     *     "column_name" =>
     *     [
     *         "in|nin|like|gt|ge|lt|le|eq" => ["value", ...]
     *     ]
     *
     * ]
     *
     * in: Query for data IN the values provided. (Pass array of values as value)
     *
     * nin: Query for data NOT IN the values provided. (Pass array as value)
     *
     * like: Query for data LIKE the value provided (Pass string as value).
     *
     * nlike: Query for data NOT LIKE the value provided (Pass string as value).
     *
     * gt: Query for data GREATER THAN the value provided (Pass string as value).
     *
     * ge: Query for data GREATER THAN OR EQUAL TO the value provided (Pass string as value).
     *
     * lt: Query for data LESS THAN the value provided (Pass string as value).
     *
     * le: Query for data LESS THAN OR EQUAL TO the value provided (Pass string as value).
     *
     * eq: Query for data EQUAL TO the value provided (Pass string as value).
     *
     * neq: Query for data NOT EQUAL TO the value provided (Pass string as value).
     *
     * @return array Array of associative arrays,
     * the associative arrays will have columns as keys and row values as values.
     */
    public function read(string $table, array $select = ['*'], array $where = []): array;
}