<?php

namespace Base\Facades;

use Base\Api\DirectoryListInterface;

/**
 * Class DirectoryList
 *
 * Facade class for the directory list component.
 *
 * @package Base\Facades
 * @since 2020-05-08
 * @author Danny Damsky
 * @see DirectoryListInterface
 *
 * @method static string getBasePath(string $path = '') Get the base application path.
 * @method static string getApplicationPath() Get the path for the application code.
 * @method static string getFrameworkPath() Get the path for the framework's code.
 * @method static string getConfigurationsPath() Get the path for the configuration files.
 * @method static string getDatabasePath(string $path = '') Get the database path.
 * @method static string getMigrationsPath(string $path) Get the path for the database migrations.
 */
final class DirectoryList extends Facade
{
    /**
     * Class/DI tag that should be accessed by the Facade using static methods.
     */
    public const FACADE_ACCESSOR = DirectoryListInterface::class;
}