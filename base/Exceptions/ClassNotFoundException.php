<?php

namespace Base\Exceptions;

use ReflectionException;
use function __;

/**
 * Class ClassNotFoundException
 * @package Base\Exception
 * @since 2020-05-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class ClassNotFoundException extends ReflectionException
{
    /**
     * Build an exception object with an appropriate message.
     *
     * @param string $class
     * @return ClassNotFoundException
     */
    public static function build(string $class): self
    {
        return new static(
            __(
                'The class %1 does not exist and cannot be instantiated using dependency injection.',
                $class
            )
        );
    }
}