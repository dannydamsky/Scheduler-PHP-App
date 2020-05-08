<?php

namespace Base\Framework\App;

use Base\Api\ConfigurationInterface;
use Base\Api\DirectoryListInterface;
use Base\Exceptions\FolderNotFoundException;
use function explode;
use function is_dir;
use function scandir;
use function str_replace;
use function substr;
use const SCANDIR_SORT_NONE;

/**
 * Class Configuration
 *
 * Implementation of {@see ConfigurationInterface}.
 *
 * @package Base\Framework\App
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * An array of the application configurations.
     */
    private array $configs = [];

    /**
     * Configuration constructor.
     * @param DirectoryListInterface $directoryList
     * @throws FolderNotFoundException
     */
    public function __construct(DirectoryListInterface $directoryList)
    {
        $configsPath = $directoryList->getConfigurationsPath();
        if (!is_dir($configsPath)) {
            throw FolderNotFoundException::build($configsPath);
        }
        $this->loadConfigurationFiles($configsPath);
    }

    /**
     * Load the configuration files for the application.
     *
     * @param string $configsPath
     */
    private function loadConfigurationFiles(string $configsPath): void
    {
        foreach (scandir($configsPath, SCANDIR_SORT_NONE) as $pathItem) {
            if (substr($pathItem, -4) === '.php') {
                /**
                 * Reason behind no inspection:
                 * Files inside the config folder are expected to return
                 * an array.
                 *
                 * @noinspection PhpIncludeInspection
                 */
                $this->configs[str_replace('.php', '', $pathItem)] = include "{$configsPath}/{$pathItem}";
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, $default = null)
    {
        $innerObjects = explode('.', $key);
        $current = $this->configs;
        foreach ($innerObjects as $object) {
            if (!isset($current[$object])) {
                return $default;
            }
            $current = $current[$object];
        }
        return $current;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->configs;
    }
}