<?php

namespace Base\Framework;

use Base\Api\ApplicationInterface;
use Base\Api\ConfigurationInterface;
use Base\Api\DirectoryListInterface;
use Base\Api\EnvironmentInterface;
use Base\Api\ObjectManagerInterface;
use Base\Api\ProviderInterface;
use Base\Console\Commands\Command;

/**
 * Class Application
 * @package Base\Framework
 * @since 2020-05-07
 * @author Danny Damsky
 */
final class Application implements ApplicationInterface
{
    private ObjectManagerInterface $objectManager;
    private DirectoryListInterface $directoryList;
    private EnvironmentInterface $environment;
    private ConfigurationInterface $configuration;

    /**
     * Application constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param DirectoryListInterface $directoryList
     * @param EnvironmentInterface $environment
     * @param ConfigurationInterface $configuration
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        DirectoryListInterface $directoryList,
        EnvironmentInterface $environment,
        ConfigurationInterface $configuration
    )
    {
        $this->objectManager = $objectManager;
        $this->directoryList = $directoryList;
        $this->environment = $environment;
        $this->configuration = $configuration;
    }

    /**
     * @inheritDoc
     */
    public function start(int $argc, array $argv): void
    {
        $this->initProviders();
        $this->loadCommand($argc, $argv);
    }

    /**
     * Initialize the application service providers.
     */
    private function initProviders(): void
    {
        $providers = $this->configuration->get('app.providers', []);
        $this->registerProviders($providers);
        $this->bootProviders($providers);
    }

    /**
     * Run the {@see ProviderInterface::register()} method on all
     * the configured service providers.
     *
     * @param ProviderInterface[] $providers
     */
    private function registerProviders(array $providers): void
    {
        foreach ($providers as $provider) {
            $this->objectManager->get($provider)->register();
        }
    }

    /**
     * Run the {@see ProviderInterface::boot()} method on all
     * the configured service providers.
     *
     * @param ProviderInterface[] $providers
     */
    private function bootProviders(array $providers): void
    {
        foreach ($providers as $provider) {
            $this->objectManager->get($provider)->boot();
        }
    }

    /**
     * Load the command passed as an argument to the application's entry point.
     *
     * @param int $argc
     * @param array $argv
     */
    private function loadCommand(int $argc, array $argv): void
    {
        $commands = $this->configuration->get('app.commands', []);
        if ($argc === 1 || !isset($commands[$argv[1]])) {
            echo "\n\tAvailable commands:\n";
            foreach (array_keys($commands) as $command) {
                echo "\t\t$command\n";
            }
            echo "\n";
            return;
        }
        /** @var Command $command */
        $command = $this->objectManager->get($commands[$argv[1]]);
        $command->execute($argv);
    }

    /**
     * @inheritDoc
     */
    public function getObjectManager(): ObjectManagerInterface
    {
        return $this->objectManager;
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryList(): DirectoryListInterface
    {
        return $this->directoryList;
    }

    /**
     * @inheritDoc
     */
    public function getEnvironment(): EnvironmentInterface
    {
        return $this->environment;
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): ConfigurationInterface
    {
        return $this->configuration;
    }
}