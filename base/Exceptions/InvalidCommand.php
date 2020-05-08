<?php

namespace Base\Exceptions;

use BadMethodCallException;

/**
 * Class InvalidCommand
 * @package Base\Exception
 * @since 2020-05-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class InvalidCommand extends BadMethodCallException
{
    /**
     * Build an instance of this exception with the given message.
     *
     * @param string $message
     * @return static
     */
    public static function build(string $message): self
    {
        return new static($message);
    }
}