<?php

namespace Base\Framework\Database\Adapter;

use PDO as Connection;
use function array_keys;
use function config;
use function implode;
use function reset;
use function substr;

/**
 * Class Mysql
 * @package Base\Framework\Database\Adapter
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class Mysql extends Pdo
{
    /**
     * A conversion of the framework's standard
     * comparison syntax to MySQL operators.
     */
    private const STD_COMPARE_SYNTAX_TO_MYSQL = [
        'in' => 'IN',
        'nin' => 'NOT IN',
        'like' => 'LIKE',
        'nlike' => 'NOT LIKE',
        'gt' => '>',
        'ge' => '>=',
        'lt' => '<',
        'le' => '<=',
        'eq' => '=',
        'neq' => '!='
    ];

    /**
     * @inheritDoc
     */
    public function getConnection(): Connection
    {
        $hostname = config('database.hostname');
        $dbName = config('database.name');
        $username = config('database.username');
        $password = config('database.password');
        return new Connection("mysql:host={$hostname};dbname={$dbName}", $username, $password);
    }


    /**
     * @inheritDoc
     */
    protected function _create(string $table, array $values): void
    {
        if (empty($values)) {
            return;
        }
        [$columnsStr, $valuesStr, $bindings] = $this->parseCreateValuesArray($values);
        $preparedStatement = $this->connection->prepare("INSERT INTO `$table` ($columnsStr) VALUES ($valuesStr);");
        $preparedStatement->execute($bindings);
    }

    /**
     * Parse the given values array used for the create statement.
     *
     * @param array $values The values to insert (Associative array with column names as keys)
     * @return array [columns string, values string, bindings array]
     */
    private function parseCreateValuesArray(array $values): array
    {
        $columnsStr = '';
        $valuesStr = '';
        $bindings = [];
        foreach ($values as $column => $value) {
            $columnsStr .= "`$column`, ";
            $valuesStr .= "?, ";
            $bindings[] = $value;
        }
        return [substr($columnsStr, 0, -2), substr($valuesStr, 0, -2), $bindings];
    }

    /**
     * @inheritDoc
     */
    protected function _update(string $table, array $values, array $where): void
    {
        if (empty($values)) {
            return;
        }
        [$columnsStr, $bindings] = $this->parseUpdateValuesArray($values);
        $whereStr = $this->parseQueryArray($where, $bindings);
        $preparedStatement = $this->connection->prepare("UPDATE `$table` SET {$columnsStr}{$whereStr};");
        $preparedStatement->execute($bindings);
    }

    /**
     * Parse the given values array used for the update statement.
     *
     * @param array $values The values to update (Associative array with column names as keys)
     * @return array [columns string, bindings array]
     */
    private function parseUpdateValuesArray(array $values): array
    {
        $columnsStr = '';
        $bindings = [];
        foreach ($values as $column => $value) {
            $columnsStr .= "`$column` = ?, ";
            $bindings[] = $value;
        }
        return [substr($columnsStr, 0, -2), $bindings];
    }

    /**
     * @inheritDoc
     */
    protected function _delete(string $table, array $where): void
    {
        $bindings = [];
        $whereStr = $this->parseQueryArray($where, $bindings);
        $preparedStatement = $this->connection->prepare("DELETE FROM `$table`{$whereStr};");
        $preparedStatement->execute($bindings);
    }

    /**
     * @inheritDoc
     */
    protected function _read(string $table, array $select, array $where): array
    {
        $bindings = [];
        $whereStr = $this->parseQueryArray($where, $bindings);
        $selectStr = $this->parseSelectArray($select);
        $preparedStatement = $this->connection->prepare("SELECT $selectStr FROM `$table`{$whereStr};");
        $preparedStatement->execute($bindings);
        return (array)$preparedStatement->fetchAll();
    }

    /**
     * Parse the select array and convert it into a MySQL columns select string.
     *
     * @param array $select
     * @return string
     */
    private function parseSelectArray(array $select): string
    {
        if ($select === ['*']) {
            return '*';
        }
        return '`' . implode('`,', $select) . '`';
    }

    /**
     * Parse the query array and convert it into a MySQL query syntax string.
     *
     * @param array $where
     * @param array $bindings
     * @return string
     */
    private function parseQueryArray(array $where, array &$bindings): string
    {
        if (empty($where)) {
            return '';
        }
        $whereStr = ' WHERE ';
        $and = null;
        foreach ($where as $column => $comparison) {
            // Determine whether to concatenate string with AND/OR
            $and = $comparison['and'] ?? true;
            unset($comparison['and']);

            // Retrieve the operator (=,>=,<=,<,>,LIKE,NOT LIKE,IN,NOT IN)
            $operator = self::STD_COMPARE_SYNTAX_TO_MYSQL[array_keys($comparison)[0]];

            // Retrieve the right operand.
            $values = reset($comparison);

            // Concatenated the left operand and operator to the WHERE query string.
            $whereStr .= "`$column` $operator ";

            // If the operator is IN or NOT IN the $values variable is expected to be an array.
            if ($operator === 'IN' || $operator === 'NOT IN') {
                $whereStr .= '(';
                foreach ($values as $value) {
                    $bindings[] = $value;
                    $whereStr .= '?, ';
                }
                $whereStr = substr($whereStr, 0, -2) . ')';
            } else {
                $bindings[] = $values;
                $whereStr .= '?';
            }

            $whereStr .= $and ? ' AND ' : ' OR ';
        }
        if ($and) { // Remove " AND " from the end of $whereStr.
            $whereStr = substr($whereStr, 0, -5);
        } else { // Remove " OR " from the end of $whereStr.
            $whereStr = substr($whereStr, 0, -4);
        }
        return $whereStr;
    }
}