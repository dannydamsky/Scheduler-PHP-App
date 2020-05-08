<?php

namespace Base\Framework\App;

use Base\Api\DirectoryListInterface;
use Base\Api\EnvironmentInterface;
use Base\Exceptions\FileNotFoundException;
use Base\Exceptions\FileReadException;
use function explode;
use function file_exists;
use function file_get_contents;
use function strpos;
use function trim;

/**
 * Class Environment
 *
 * Implementation of {@see EnvironmentInterface}.
 *
 * @package Base\Framework\App
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class Environment implements EnvironmentInterface
{
    /**
     * An array of environment variables retrieved
     * from the application's .env file.
     *
     * @var array
     */
    private array $variables = [];

    /**
     * Environment constructor.
     * @param DirectoryListInterface $directoryList
     * @throws FileNotFoundException
     * @throws FileReadException
     */
    public function __construct(DirectoryListInterface $directoryList)
    {
        $filePath = $directoryList->getBasePath('.env');
        if (!file_exists($filePath)) {
            throw FileNotFoundException::build($filePath);
        }
        $this->parseEnvFile($this->readEnvFile($filePath));
    }

    /**
     * Read the .env file and return its contents.
     *
     * @param string $filePath
     * @return string
     * @throws FileReadException
     */
    private function readEnvFile(string $filePath): string
    {
        $contents = file_get_contents($filePath);
        if ($contents === false) {
            throw FileReadException::build($filePath);
        }
        return $contents;
    }

    /**
     * Parse the .env file into a PHP array of key => value pairs.
     *
     * @param string $fileContents
     */
    private function parseEnvFile(string $fileContents): void
    {
        $lines = explode("\n", $fileContents);
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || strpos($line, '=') === false) {
                continue;
            }
            [$key, $value] = explode('=', $line);
            $this->variables[trim($key)] = trim($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, ?string $default = null): ?string
    {
        return $this->variables[$key] ?? $default;
    }

    /**
     * @inheritDoc
     */
    public function all(): array
    {
        return $this->variables;
    }
}