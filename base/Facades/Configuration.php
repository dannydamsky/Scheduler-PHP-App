<?php

namespace Base\Facades;

use Base\Api\ConfigurationInterface;

/**
 * Class Configuration
 *
 * Facade class for the configuration application component.
 *
 * @package Base\Facades
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 * @see ConfigurationInterface
 *
 * @method static mixed get(string $key, $default = null) Retrieve the value for the given key from the configurations.
 * @method static mixed[] all() Retrieve all configurations.
 */
final class Configuration extends Facade
{
    /**
     * Class/DI tag that should be accessed by the Facade using static methods.
     */
    public const FACADE_ACCESSOR = ConfigurationInterface::class;
}