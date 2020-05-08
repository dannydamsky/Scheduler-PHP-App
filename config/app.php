<?php

use App\Console\Commands\CronRun;
use App\Console\Commands\OperationExecute;
use App\Console\Commands\ScheduleRandomDataCreate;
use App\Console\Commands\ScheduleRandomDataDelete;
use App\Console\Commands\ScheduleRandomDataUpdate;
use Base\Console\Commands\Migrate;
use Base\Api\ConfigurationInterface;
use Base\Api\DatabaseAdapterInterface;
use Base\Api\DirectoryListInterface;
use Base\Api\EnvironmentInterface;
use Base\Framework\Database\Adapter\Mysql;
use Base\Framework\Providers\ApplicationProvider;
use Base\Framework\Providers\DatabaseProvider;

return [
    /*
     * Enables/Disables the debug mode.
     */
    'debug' => env('APP_DEBUG', 'true') === 'true',

    /*
     * Sets the current timezone.
     */
    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
     * Dependency injection bindings.
     */
    'aliases' => [
        // Framework dependencies - Start.
        'dirs' => DirectoryListInterface::class,
        'env' => EnvironmentInterface::class,
        'config' => ConfigurationInterface::class,
        'db' => DatabaseAdapterInterface::class,
        'mysql' => Mysql::class
        // Framework dependencies - End.
    ],

    /*
     * Service providers.
     */
    'providers' => [
        // Framework dependencies - Start.
        ApplicationProvider::class,
        DatabaseProvider::class
        // Framework dependencies - End.
    ],

    /*
     * Console commands.
     */
    'commands' => [
        // Framework dependencies - Start
        'migrate' => Migrate::class,
        // Framework dependencies - End

        'cron:run' => CronRun::class,
        'operation:execute' => OperationExecute::class,
        'schedule:random-data:create' => ScheduleRandomDataCreate::class,
        'schedule:random-data:update' => ScheduleRandomDataUpdate::class,
        'schedule:random-data:delete' => ScheduleRandomDataDelete::class
    ]
];