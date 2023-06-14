<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('memory_limit', '1024M');

function my_autoloader($class)
{
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $extension = '.class.php';
    if (strpos($url, 'includes') !== false) {
        $path = '../classes/';
    } else {
        $path = 'classes/';
    }
    $fullPath = $path . str_replace('\\', '/', $class) . $extension;
    if (!file_exists($fullPath)) {
        return false;
    }
    require_once $fullPath;
}

spl_autoload_register('my_autoloader');
