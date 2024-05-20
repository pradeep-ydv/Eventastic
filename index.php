<?php
// Define the root path of the project
define("ROOT_PATH", __DIR__ . DIRECTORY_SEPARATOR);
// echo ROOT_PATH;exit;
// Include the Composer autoload file for managing dependencies
require_once(ROOT_PATH . "vendor" . DIRECTORY_SEPARATOR . "autoload.php");

// Register an autoload function to automatically include class files
spl_autoload_register(function ($class) {
    // Replace namespace separators with directory separators in the class name
    $classFile = str_replace("\\", DIRECTORY_SEPARATOR, $class . ".php");

    // Build the full path to the class file
    $classPath = ROOT_PATH . "app" . DIRECTORY_SEPARATOR . $classFile;

    // Check if the class file exists and include it if it does
    if (file_exists($classPath)) {
        require_once($classPath);
    }
});

// Start a new or resume an existing session
session_start();

use App\Services\Route;

$routes = new Route();

require_once(ROOT_PATH . "/routes/route.php");

$routes->handle();