<?php

namespace Base\Facades;

use Base\Framework\App\ObjectManager;
use function call_user_func_array;

/**
 * Class Facade
 *
 * An implementation of a Facade design pattern.
 *
 * @package Base\Facades
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
abstract class Facade
{
    /**
     * Class/DI tag that should be accessed by the Facade using static methods.
     */
    protected const FACADE_ACCESSOR = null;

    /**
     * Get the class/DI tag that should be accessed by the Facade using static methods.
     */
    protected static function getFacadeAccessor(): string
    {
        return static::FACADE_ACCESSOR;
    }

    /**
     * Call the methods of the facade accessor instance.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    final public static function __callStatic(string $name, array $arguments)
    {
        $objectManager = ObjectManager::getInstance();
        $instance = $objectManager->get(static::getFacadeAccessor());
        return call_user_func_array([$instance, $name], $arguments);
    }
}