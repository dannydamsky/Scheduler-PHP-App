<?php

namespace Base\Facades;

use Base\Api\EnvironmentInterface;

/**
 * Class Environment
 *
 * Facade class for the environment application component.
 *
 * @package Base\Facades
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see EnvironmentInterface
 *
 * @method static string|null get(string $key, ?string $default = null) Retrieve the value for the given key from the environment variables.
 * @method static string[] all() Retrieve all environment variables.
 */
final class Environment extends Facade
{
    /**
     * Class/DI tag that should be accessed by the Facade using static methods.
     */
    public const FACADE_ACCESSOR = EnvironmentInterface::class;
}