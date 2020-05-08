<?php

namespace Base\Console\Commands;

use Base\Api\DirectoryListInterface;
use function __;
use function scandir;
use function substr;
use const DIRECTORY_SEPARATOR;

/**
 * Class Migrate
 * @package Base\Console\Commands
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
final class Migrate extends Command
{
    private DirectoryListInterface $directoryList;

    /**
     * Migrate constructor.
     * @param DirectoryListInterface $directoryList
     */
    public function __construct(DirectoryListInterface $directoryList)
    {
        $this->directoryList = $directoryList;
    }

    /**
     * Handle the execution of the command.
     */
    public function handle(): void
    {
        $migrationsPath = $this->directoryList->getMigrationsPath();
        foreach (scandir($migrationsPath) as $migrationItem) {
            if (substr($migrationItem, -4) !== '.php') {
                continue;
            }
            echo __("Running for %1 ...", $migrationItem) . "\n";
            /**
             * Files inside the migrations path
             * are expected to execute a database migration.
             *
             * @noinspection PhpIncludeInspection
             */
            include $migrationsPath . DIRECTORY_SEPARATOR . $migrationItem;
        }
    }
}