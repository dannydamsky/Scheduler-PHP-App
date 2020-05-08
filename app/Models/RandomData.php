<?php

namespace App\Models;

use Base\Models\Model;

/**
 * Class RandomData
 * @package App\Models
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class RandomData extends Model
{
    /**
     * Random data database table name.
     */
    public const TABLE_NAME = 'random_data';

    /**
     * Random data database table primary key.
     */
    public const PRIMARY_KEY = 'entityId';

    /**
     * Entity ID.
     *
     * @var int
     */
    protected int $entityId;

    /**
     * Value.
     *
     * @var string
     */
    protected string $value;

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
     * Get the value.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set the value.
     *
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}