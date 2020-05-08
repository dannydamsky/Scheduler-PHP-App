<?php

namespace App\Models;

use Base\Models\Model;
use function serialize;
use function unserialize;

/**
 * Class Operation
 * @package App\Models
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class Operation extends Model
{
    /**
     * Operations database table name.
     */
    public const TABLE_NAME = 'operations';

    /**
     * Operations database table primary key.
     */
    public const PRIMARY_KEY = 'entityId';

    /**
     * Operation type constant - Create operation.
     */
    public const OPERATION_TYPE_CREATE = 1;

    /**
     * Operation type constant - Update operation.
     */
    public const OPERATION_TYPE_UPDATE = 2;

    /**
     * Operation type constant - Delete operation.
     */
    public const OPERATION_TYPE_DELETE = 3;

    /**
     * Create an operation for the model and operation type.
     *
     * @param Model $model
     * @param int $operationType
     */
    public static function create(Model $model, int $operationType): void
    {
        $operation = new self();
        $operation->setData($model->toArray());
        $operation->setModel(get_class($model));
        $operation->setType($operationType);
        $operation->save();
    }

    /**
     * Entity ID.
     *
     * @var int
     */
    protected int $entityId;

    /**
     * Entity model class name.
     *
     * @var string
     */
    protected string $model;

    /**
     * Operation type.
     *
     * @var int
     * @see Operation::OPERATION_TYPE_CREATE
     * @see Operation::OPERATION_TYPE_UPDATE
     * @see Operation::OPERATION_TYPE_DELETE
     */
    protected int $type;

    /**
     * Serialized data for create/update/delete.
     *
     * @var string
     */
    protected string $data;

    /**
     * Creation timestamp.
     *
     * @var string
     */
    protected string $createdAt;

    /**
     * Get the entity ID.
     *
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }

    /**
     * Set the entity ID.
     *
     * @param int $entityId
     */
    public function setEntityId(int $entityId): void
    {
        $this->entityId = $entityId;
    }

    /**
     * Get the entity model class name.
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Set the entity model class name.
     *
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * Get the operation type.
     *
     * @return int
     * @see Operation::OPERATION_TYPE_CREATE
     * @see Operation::OPERATION_TYPE_UPDATE
     * @see Operation::OPERATION_TYPE_DELETE
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * Set the operation type.
     *
     * @param int $type
     * @see Operation::OPERATION_TYPE_CREATE
     * @see Operation::OPERATION_TYPE_UPDATE
     * @see Operation::OPERATION_TYPE_DELETE
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * Get the serialized data for create/update/delete.
     *
     * @return array
     */
    public function getData(): array
    {
        return unserialize($this->data);
    }

    /**
     * Set the serialized data for create/update/delete.
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = serialize($data);
    }

    /**
     * Get the creation timestamp.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Set the creation timestamp.
     *
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}