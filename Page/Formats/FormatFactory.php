<?php
namespace Page\Formats;

use Exception;

class FormatFactory
{
    public function make($format)
    {
        $class = __NAMESPACE__ . '\\' . $format;
        if (!class_exists($class)) {
            throw new Exception("The format chosen ({$format}) does not exist.");
        }

        return new $class;
    }
}