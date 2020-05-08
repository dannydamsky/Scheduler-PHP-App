<?php

namespace Base\Exceptions;

use function __;

/**
 * Class FolderNotFoundException
 * @package Base\Exceptions
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class FolderNotFoundException extends FilesystemException
{
    /**
     * Build an exception with an appropriate message.
     *
     * @param string $absolutePath
     * @return static
     */
    public static function build(string $absolutePath): self
    {
        return new static(
            __(
                'The folder "%1" cannot be found.',
                $absolutePath
            )
        );
    }
}