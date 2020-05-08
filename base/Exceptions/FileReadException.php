<?php

namespace Base\Exceptions;

/**
 * Class FileReadException
 * @package Base\Exceptions
 * @since 2020-05-08
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */
class FileReadException extends FilesystemException
{
    /**
     * Build an exception with an appropriate message.
     *
     * @param string $filePath
     * @return FileReadException
     */
    public static function build(string $filePath): self
    {
        return new static(
            __(
                'Failed to read the file "%1", please check that the application has access permissions for this file and that the file is not corrupted.',
                $filePath
            )
        );
    }
}