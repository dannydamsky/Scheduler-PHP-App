<?php

namespace Base\Framework\Database\Adapter;

use Base\Api\DatabaseAdapterInterface;
use Base\Exceptions\DatabaseException;
use PDO as Connection;
use PDOException as ConnectionException;
use Throwable;

/**
 * Class Pdo
 *
 * Abstract class for all database drivers
 * that use {@see \PDO} to connect.
 *
 * @package Base\Framework\Database\Adapter
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
abstract class Pdo implements DatabaseAdapterInterface
{

    /**
     * The database connection object.
     */
    protected ?Connection $connection;

    /**
     * Pdo constructor.
     */
    public function __construct()
    {
        $this->connection = $this->getConnection();
        $this->connection->setAttribute(Connection::ATTR_DEFAULT_FETCH_MODE, Connection::FETCH_ASSOC);
        $this->connection->setAttribute(Connection::ATTR_ERRMODE, Connection::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(Connection::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Retrieve the PDO connection.
     *
     * @return Connection
     */
    abstract public function getConnection(): Connection;

    /**
     * @inheritDoc
     */
    final public function executeRaw(string $statement)
    {
        return $this->connection->exec($statement);
    }

    /**
     * @inheritDoc
     */
    final public function beginTransaction(): void
    {
        $this->runTransactionMethod('beginTransaction', 'Failed to begin transaction.');
    }

    /**
     * @inheritDoc
     */
    final public function commit(): void
    {
        $this->runTransactionMethod('commit', 'Failed to commit transaction.');
    }

    /**
     * @inheritDoc
     */
    final public function rollback(): void
    {
        $this->runTransactionMethod('rollBack', 'Failed to roll back the transaction after failure.');
    }

    /**
     * Run a transaction method on the {@see Mysql::$connection} property.
     *
     * @param string $method The name of the method to run on {@see Mysql::$connection}, method must return boolean.
     * @param string $errorMessage The error message to use in case of failure.
     */
    private function runTransactionMethod(string $method, string $errorMessage): void
    {
        try {
            if (!$this->connection->{$method}()) {
                throw new DatabaseException($errorMessage);
            }
        } catch (ConnectionException $e) {
            throw new DatabaseException($e->getMessage(), 0, $e->getPrevious());
        }
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    final public function runInTransaction(callable $statements)
    {
        try {
            $this->beginTransaction();
            $result = $statements();
            $this->commit();
            return $result;
        } catch (ConnectionException $e) {
            throw new DatabaseException($e->getMessage(), 0, $e->getPrevious());
        } catch (Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    final public function create(string $table, array $values): void
    {
        try {
            $this->_create($table, $values);
        } catch (ConnectionException $e) {
            throw new DatabaseException($e->getMessage(), 0, $e->getPrevious());
        }
    }

    /**
     * @inheritDoc
     */
    final public function update(string $table, array $values, array $where = []): void
    {
        try {
            $this->_update($table, $values, $where);
        } catch (ConnectionException $e) {
            throw new DatabaseException($e->getMessage(), 0, $e->getPrevious());
        }
    }

    /**
     * @inheritDoc
     */
    final public function delete(string $table, array $where = []): void
    {
        try {
            $this->_delete($table, $where);
        } catch (ConnectionException $e) {
            throw new DatabaseException($e->getMessage(), 0, $e->getPrevious());
        }
    }

    /**
     * @inheritDoc
     */
    final public function read(string $table, array $select = ['*'], array $where = []): array
    {
        try {
            return $this->_read($table, $select, $where);
        } catch (ConnectionException $e) {
            throw new DatabaseException($e->getMessage(), 0, $e->getPrevious());
        }
    }

    /**
     * Called by {@see DatabaseAdapterInterface::create()}.
     *
     * @param string $table
     * @param array $values
     */
    abstract protected function _create(string $table, array $values): void;

    /**
     * Called by {@see DatabaseAdapterInterface::update()}.
     *
     * @param string $table
     * @param array $values
     * @param array $where
     */
    abstract protected function _update(string $table, array $values, array $where): void;

    /**
     * Called by {@see DatabaseAdapterInterface::delete()}.
     *
     * @param string $table
     * @param array $where
     */
    abstract protected function _delete(string $table, array $where): void;

    /**
     * Called by {@see DatabaseAdapterInterface::read()}.
     *
     * @param string $table
     * @param array $select
     * @param array $where
     * @return array
     */
    abstract protected function _read(string $table, array $select, array $where): array;

    /**
     * Make sure that the database connection is properly destroyed.
     */
    final public function __destruct()
    {
        $this->connection = null;
    }
}