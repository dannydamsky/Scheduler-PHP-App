<?php

namespace App\Models;

use Base\Models\Model;
use function date;
use function strtotime;

/**
 * Class Cron
 * @package App\Models
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class Cron extends Model
{
    /**
     * Cron table's primary key.
     */
    public const PRIMARY_KEY = 'entityId';

    /**
     * Cron database table name.
     */
    public const TABLE_NAME = 'crons';

    /**
     * Create a cron for the given command and time.
     *
     * @param string $command The command to schedule.
     * @param string $deltaTime The time delta in human-readable form (For example: "+1 hour")
     */
    public static function create(string $command, string $deltaTime): void
    {
        $cron = new self();
        $cron->setCommand($command);
        $cron->setScheduledAt(date('Y-m-d H:i:s', strtotime($deltaTime)));
        $cron->save();
    }

    /**
     * Entity ID.
     */
    protected int $entityId;

    /**
     * The name of the command to execute.
     */
    protected string $command;

    /**
     * The date when the command is scheduled to execute.
     */
    protected string $scheduledAt;

    /**
     * Command execution start time.
     */
    protected ?string $executedFrom;

    /**
     * Command execution end time.
     */
    protected ?string $executedTo;

    /**
     * Cron creation timestamp.
     */
    protected string $createdAt;

    /**
     * Cron modification timestamp.
     */
    protected string $updatedAt;

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
     * Get the command to execute for this cron.
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * Set the command to execute for this cron.
     *
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

    /**
     * Get the date when the command is scheduled to execute.
     *
     * @return string
     */
    public function getScheduledAt(): string
    {
        return $this->scheduledAt;
    }

    /**
     * Set the date when the command is scheduled to execute.
     *
     * @param string $scheduledAt
     */
    public function setScheduledAt(string $scheduledAt): void
    {
        $this->scheduledAt = $scheduledAt;
    }

    /**
     * Get the execution start time of the command.
     *
     * @return string|null
     */
    public function getExecutedFrom(): ?string
    {
        return $this->executedFrom;
    }

    /**
     * Set the execution start time of the command.
     *
     * @param string|null $executedFrom
     */
    public function setExecutedFrom(?string $executedFrom): void
    {
        $this->executedFrom = $executedFrom;
    }

    /**
     * Get the execution end time of the command.
     *
     * @return string|null
     */
    public function getExecutedTo(): ?string
    {
        return $this->executedTo;
    }

    /**
     * Set the execution end time of the command.
     *
     * @param string|null $executedTo
     */
    public function setExecutedTo(?string $executedTo): void
    {
        $this->executedTo = $executedTo;
    }

    /**
     * Get the creation timestamp of this cron.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Set the creation timestamp of this cron.
     *
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the modification timestamp of this cron.
     *
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * Set the modification timestamp of this cron.
     *
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


}