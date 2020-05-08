<?php

namespace Base\Framework\Providers;

use Base\Api\DatabaseAdapterInterface;
use Base\Framework\Database\Adapter\Mysql;
use function config;

/**
 * Class DatabaseProvider
 *
 * Initializes the database components.
 *
 * @package Base\Framework\Providers
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class DatabaseProvider extends ServiceProvider
{

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->app->bind('mysql', Mysql::class);
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $databaseDriver = config('database.driver');
        $this->app->bind(DatabaseAdapterInterface::class, $databaseDriver);
        $this->app->bind('db', $databaseDriver);
    }
}