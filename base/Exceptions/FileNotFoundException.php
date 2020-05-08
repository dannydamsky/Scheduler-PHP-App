<?php

namespace Base\Exceptions;

use function __;

/**
 * Class FileNotFoundException
 * @package Base\Exceptions
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class FileNotFoundException extends FilesystemException
{
    /**
     * Build an exception with an appropriate message.
     *
     * @param string $absoluteFilePath
     * @return static
     */
    public static function build(string $absoluteFilePath): self
    {
        return new static(
            __(
                'The file "%1" cannot be found.',
                $absoluteFilePath
            )
        );
    }
}