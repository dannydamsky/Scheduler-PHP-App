<?php

namespace Base\Api;

/**
 * Interface ConfigurationInterface
 *
 * This interface should be implemented by the
 * configuration component.
 *
 * The configuration component is used for retrieving
 * application-specific configuration data.
 *
 * @package Base\Api
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
interface ConfigurationInterface
{
    /**
     * Retrieve the value for the given key from the configurations.
     *
     * @param string $key The key that you wish to retrieve from the configurations.
     * @param mixed $default The default value to return in case the config for the given key was not found.
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Retrieve all configurations.
     *
     * @return mixed[] (Associative array)
     */
    public function all(): array;
}