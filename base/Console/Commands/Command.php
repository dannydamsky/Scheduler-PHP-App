<?php

namespace Base\Console\Commands;

use Base\Exceptions\InvalidCommand;
use ReflectionClass;
use ReflectionException;
use function array_splice;
use function call_user_func_array;

/**
 * Class Command
 *
 * Abstract class that defines the base logic
 * for commands used in this application.
 *
 * Extending classes must implement the handle method
 * with the arguments that they're expecting to retrieve.
 *
 * @package Base\Console\Commands
 * @since 2020-05-07
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
abstract class Command
{
    /**
     * Used for determining whether the current command class has been
     * correctly implemented.
     *
     * @var bool|null
     */
    protected static ?bool $isValid = null;

    /**
     * Get whether the current command class has been
     * correctly implemented.
     *
     * @return bool
     */
    final protected static function isValid(): bool
    {
        if (static::$isValid === null) {
            try {
                $reflectionClass = new ReflectionClass(static::class);
                $handle = $reflectionClass->getMethod('handle'); // This throws an exception if the method doesn't exist.
                static::$isValid = $handle->isPublic(); // Method must be public.
            } catch (ReflectionException $e) {
                static::$isValid = false;
            }
        }
        return static::$isValid;
    }

    /**
     * Execute the command.
     *
     * @param array $argv Command arguments.
     */
    final public function execute(array $argv): void
    {
        if (!static::isValid()) {
            throw InvalidCommand::build(__('Command class has been incorrectly implemented.', static::class));
        }
        call_user_func_array([$this, 'handle'], array_splice($argv, 2));
    }
}