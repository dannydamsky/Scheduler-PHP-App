<?php

namespace Base\Framework\App;

use Base\Api\DirectoryListInterface;
use const BASE_PATH;
use const DIRECTORY_SEPARATOR;

/**
 * Class DirectoryList
 *
 * Implementation of {@see DirectoryListInterface}.
 *
 * @package Base\Framework\App
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class DirectoryList implements DirectoryListInterface
{
    /**
     * Base application path.
     *
     * @var string
     */
    private string $basePath = BASE_PATH;

    /**
     * Directory separator.
     *
     * @var string
     */
    private string $dirSeparator = DIRECTORY_SEPARATOR;

    /**
     * @inheritDoc
     */
    public function getBasePath(string $path = ''): string
    {
        if ($path === '') {
            return $this->basePath;
        }
        return "{$this->basePath}{$this->dirSeparator}{$path}";
    }

    /**
     * @inheritDoc
     */
    public function getApplicationPath(): string
    {
        return $this->getBasePath('app');
    }

    /**
     * @inheritDoc
     */
    public function getFrameworkPath(): string
    {
        return $this->getBasePath('base');
    }

    /**
     * @inheritDoc
     */
    public function getConfigurationsPath(): string
    {
        return $this->getBasePath('config');
    }

    /**
     * @inheritDoc
     */
    public function getDatabasePath(string $path = ''): string
    {
        if ($path === '') {
            return $this->getBasePath('database');
        }
        return $this->getBasePath("database{$this->dirSeparator}{$path}");
    }

    /**
     * @inheritDoc
     */
    public function getMigrationsPath(): string
    {
        return $this->getDatabasePath('migrations');
    }
}