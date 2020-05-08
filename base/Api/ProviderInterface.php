<?php

namespace Base\Api;

/**
 * Interface ProviderInterface
 *
 * This interface is used by providers defined in the application.
 * Providers are a way to initialize components/dependency injection
 * before the application logic starts.
 *
 * @package Base\Api
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface ProviderInterface
{
    /**
     * Register your components/dependency injection under this method.
     */
    public function register(): void;

    /**
     * Bootstrap your application.
     * Method runs after all other {@see ProviderInterface::register()} methods finished.
     */
    public function boot(): void;
}