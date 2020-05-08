<?php

/**
 * functions.php
 *
 * Contains helper functions.
 *
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @since 2020-05-07
 */

use Base\Api\ApplicationInterface;
use Base\Facades\Configuration;
use Base\Facades\DirectoryList;
use Base\Facades\Environment;
use Base\Framework\App\ObjectManager;

if (!function_exists('__')) {
    /**
     * Return the given text with the placeholder arguments,
     * replaced with the replacements provided in the given array.
     *
     * TODO: Can be used for adding translations in the future.
     *
     * @param string $text
     * @param string[] $replacements
     * @return string
     */
    function __(string $text, string ...$replacements): string
    {
        $replacementsCount = count($replacements);
        $searches = [];
        for ($i = 1; $i <= $replacementsCount; ++$i) {
            $searches[] = "%{$i}";
        }
        return str_replace($searches, $replacements, $text);
    }
}

if (!function_exists('env')) {
    /**
     * Helper function for retrieving environment variables.
     *
     * @param string|null $key The environment variable key to look for.
     * @param string|null $default The default value that should be returned if key is not found.
     * @return string|string[]|null String array if key is null, otherwise string or null.
     */
    function env(?string $key = null, ?string $default = null)
    {
        if ($key === null) {
            return Environment::all();
        }
        return Environment::get($key, $default);
    }
}

if (!function_exists('config')) {
    /**
     * Helper function for retrieving application config values.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed|mixed[]|null Array if key is null, otherwise single value or null.
     */
    function config(?string $key = null, $default = null)
    {
        if ($key === null) {
            return Configuration::all();
        }
        return Configuration::get($key, $default);
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the base application path.
     *
     * @param string $path Relative path, will be concatenated to the base path.
     * @return string
     */
    function base_path(string $path = ''): string
    {
        return DirectoryList::getBasePath($path);
    }
}

if (!function_exists('database_path')) {
    /**
     * Get the database path.
     *
     * @param string $path Relative path, will be concatenated to the base path.
     * @return string
     */
    function database_path(string $path = ''): string
    {
        return DirectoryList::getDatabasePath($path);
    }
}

if (!function_exists('app')) {
    /**
     * Helper function for retrieving the application instance
     * and for using the dependency injection functionality.
     *
     * @param string|null $tag Class/Tag used for binding.
     * @param string|null $className Binding class name.
     * @param bool $shared Whether to return a shared instance of the object or to create a new one.
     * @return ApplicationInterface|object|void
     */
    function app(?string $tag = null, ?string $className = null, bool $shared = true)
    {
        $objectManager = ObjectManager::getInstance();
        if ($tag === null) {
            return $objectManager->get(ApplicationInterface::class);
        }
        if ($className === null) {
            return $shared ? $objectManager->get($tag) : $objectManager->create($tag);
        }
        $objectManager->bind($tag, $className);
    }
}