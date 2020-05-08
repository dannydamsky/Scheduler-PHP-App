<?php

namespace Base\Models;

use Base\Api\DatabaseAdapterInterface;
use Base\Facades\DB;
use JsonSerializable;
use function app;
use function get_object_vars;
use function json_encode;

/**
 * Class Model
 *
 * Abstract model class used for retrieving data for extending
 * models representing database entities.
 *
 * @package Base\Models
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
abstract class Model implements JsonSerializable
{
    /**
     * Override this constant to assign a primary key to the model.
     */
    public const PRIMARY_KEY = null;

    /**
     * Override this constant to assign a table name to the model.
     */
    public const TABLE_NAME = null;

    /**
     * Retrieve all database values as an array of associative array.
     *
     * @param array $select
     * @param array $where
     * @return array
     */
    public static function getAllArray(array $select = ['*'], array $where = []): array
    {
        return DB::read(static::TABLE_NAME, $select, $where);
    }

    /**
     * Retrieve all database values as an array of models.
     *
     * @param array $where
     * @return Model[]
     */
    public static function getAll(array $where = []): array
    {
        $results = DB::read(static::TABLE_NAME, ['*'], $where);
        foreach ($results as & $item) {
            $item = new static($item);
        }
        unset($item);
        return $results;
    }

    /**
     * Get a model by its primary key.
     *
     * @param mixed $primaryKey
     * @return Model
     */
    public static function getByPrimaryKey($primaryKey): Model
    {
        return new static($primaryKey);
    }

    /**
     * Delete rows from this model's table using the given
     * query parameters.
     *
     * @param array $where
     */
    public static function deleteWhere(array $where = []): void
    {
        DB::delete(static::TABLE_NAME, $where);
    }

    private DatabaseAdapterInterface $dbAdapter;

    /**
     * Model constructor.
     * @param array|int|string|null $primaryKey
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    final public function __construct($primaryKey = null)
    {
        $this->dbAdapter = app('db');
        if ($primaryKey === null) {
            return;
        }
        if (is_array($primaryKey)) {
            $results = $primaryKey;
        } else {
            $results = $this->dbAdapter->read(static::TABLE_NAME, ['*'], [static::PRIMARY_KEY => ['eq' => $primaryKey]])[0];
        }
        foreach ($results as $column => $value) {
            $this->{$column} = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model's properties into an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $vars = get_object_vars($this);
        unset($vars['dbAdapter']);
        return $vars;
    }

    /**
     * Save (Insert or Update) the current model.
     */
    public function save(): void
    {
        $primaryKeyColumn = static::PRIMARY_KEY;
        if (empty($this->{$primaryKeyColumn})) {
            $this->dbAdapter->create(static::TABLE_NAME, $this->toArray());
        } else {
            $this->dbAdapter->update(
                static::TABLE_NAME,
                $this->toArray(),
                [
                    static::PRIMARY_KEY => ['eq' => $this->{$primaryKeyColumn}]
                ]
            );
        }
    }

    /**
     * Delete the current model.
     */
    public function delete(): void
    {
        $primaryKeyColumn = static::PRIMARY_KEY;
        $primaryKey = $this->{$primaryKeyColumn};
        if ($primaryKey !== null) {
            $this->dbAdapter->delete(static::TABLE_NAME, [
                static::PRIMARY_KEY => ['eq' => $primaryKey]
            ]);
        }
    }

    /**
     * Convert the model to a JSON string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)json_encode($this);
    }
}