<?php

namespace Base\Api;

/**
 * Interface EnvironmentInterface
 *
 * This interface should be implemented by the
 * environment component.
 *
 * The environment component is used for parsing environment variables.
 *
 * @package Base\Api
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface EnvironmentInterface
{
    /**
     * Retrieve the value for the given key from the environment variables.
     *
     * @param string $key The key that you wish to retrieve from the environment variables.
     * @param string|null $default The default value to return in case the variable for the given key was not found.
     * @return string|null
     */
    public function get(string $key, ?string $default = null): ?string;

    /**
     * Retrieve all environment variables.
     *
     * @return string[] (Associative array)
     */
    public function all(): array;
}