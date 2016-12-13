<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('__ROOT__', __DIR__);

spl_autoload_register(function($class) {
    $file = __DIR__ . '/' . str_replace('DocumentMaker\\', '', $class) . ".php";
    $file = str_replace('\\', '/', $file);

    if (file_exists($file)) {
        require_once($file);
    } else {
        die("Unknown Class: {$class}");
    }
});

require_once(__ROOT__ . '/helpers.php');