<?php

namespace Base\Api;

/**
 * Interface ApplicationInterface
 *
 * This interface should be implemented
 * by the main application component.
 *
 * The application component is used for initializing
 * all the necessary components for the application to run.
 *
 * @package Base\Api
 * @since 2020-05-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface ApplicationInterface
{
    /**
     * Start the application.
     *
     * @param int $argc Amount of arguments.
     * @param array $argv Array of arguments.
     */
    public function start(int $argc, array $argv): void;

    /**
     * Retrieve the object manager instance.
     *
     * @return ObjectManagerInterface
     */
    public function getObjectManager(): ObjectManagerInterface;

    /**
     * Retrieve the directory list instance.
     *
     * @return DirectoryListInterface
     */
    public function getDirectoryList(): DirectoryListInterface;

    /**
     * Retrieve the environment instance.
     *
     * @return EnvironmentInterface
     */
    public function getEnvironment(): EnvironmentInterface;

    /**
     * Retrieve the configuration instance.
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration(): ConfigurationInterface;
}