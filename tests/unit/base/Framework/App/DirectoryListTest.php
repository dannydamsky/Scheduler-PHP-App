<?php /** @noinspection PhpFullyQualifiedNameUsageInspection */

use PHPUnit\Framework\TestCase;

/**
 * Class DirectoryListTest
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see \Base\Framework\App\DirectoryList
 */
final class DirectoryListTest extends TestCase
{
    /**
     * @see \Base\Framework\App\DirectoryList::getBasePath()
     */
    public function test_base_path_properly_returns_path_values_with_and_without_concatenation(): void
    {
        // Base path global variable must be defined for DirectoryList to be initialized.
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__);
        }

        // Initialize object instance.
        $directoryList = new \Base\Framework\App\DirectoryList();

        // Validate base path without concatenation.
        $expected = BASE_PATH;
        $this->assertEquals($expected, $directoryList->getBasePath());

        // Validate base path with concatenations.
        $concat = 'path';
        $expected .= DIRECTORY_SEPARATOR . $concat;
        $this->assertEquals($expected, $directoryList->getBasePath($concat));
    }

    /**
     * @see \Base\Framework\App\DirectoryList::getDatabasePath()
     */
    public function test_database_path_properly_returns_path_values_with_and_without_concatenation(): void
    {
        // Base path global variable must be defined for DirectoryList to be initialized.
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', __DIR__);
        }

        // Initialize object instance.
        $directoryList = new \Base\Framework\App\DirectoryList();

        // Validate database path without concatenation.
        $expected = BASE_PATH . DIRECTORY_SEPARATOR . 'database';
        $this->assertEquals($expected, $directoryList->getDatabasePath());

        // Validate base path with concatenations.
        $concat = 'path';
        $expected .= DIRECTORY_SEPARATOR . $concat;
        $this->assertEquals($expected, $directoryList->getDatabasePath($concat));
    }
}