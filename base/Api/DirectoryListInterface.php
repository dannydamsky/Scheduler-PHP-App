<?php

namespace Base\Api;

/**
 * Interface DirectoryListInterface
 *
 * This interface should be implemented by the
 * directory list component.
 *
 * The directory list component is used for retrieving the paths
 * of important application folders.
 *
 * @package Base\Api
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface DirectoryListInterface
{
    /**
     * Get the base application path.
     *
     * @param string $path Relative path, will be concatenated to the base path.
     * @return string
     */
    public function getBasePath(string $path = ''): string;

    /**
     * Get the path for the application code.
     *
     * @return string
     */
    public function getApplicationPath(): string;

    /**
     * Get the path for the framework's code.
     *
     * @return string
     */
    public function getFrameworkPath(): string;

    /**
     * Get the path for the configuration files.
     *
     * @return string
     */
    public function getConfigurationsPath(): string;

    /**
     * Get the database path.
     *
     * @param string $path Relative path, will be concatenated to the base path.
     * @return string
     */
    public function getDatabasePath(string $path = ''): string;

    /**
     * Get the path for the database migrations.
     *
     * @return string
     */
    public function getMigrationsPath(): string;
}