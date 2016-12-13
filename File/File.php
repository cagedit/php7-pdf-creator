<?php
namespace File;

use Exception;

class File
{
    public static function read($file)
    {
        if (!is_readable($file)) {
            self::unreadable($file);
        }

        $content = file_get_contents($file);

        if ($content === false) {
            self::unreadable($file);
        }

        return $content;
    }

    public static function write($file, $content, $flags = null)
    {
        if (file_put_contents($file, $content, $flags) === false) {
            self::unwritable($file);
        }

        chmod($file, 0777);
    }

    private static function unwritable($file)
    {
        throw new Exception("Cannot write file [{$file}].");
    }

    private static function unreadable($file)
    {
        throw new Exception("Could not read file [{$file}]");
    }
}