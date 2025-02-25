<?php
session_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

const BASE_PATH = __DIR__ . '/../';

function base_path($path) {
    return BASE_PATH . $path;
}
require base_path('Core/Database.php');
require base_path('Core/Router.php');

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = base_path($class . '.php');

    if (file_exists($file)) {
        require $file;
    } else {
        die("Greška: Ne mogu da učitam klasu '$class'. Fajl ne postoji: $file");
    }
});

$config = require base_path('config.php');
$router = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');

if ($uri === '' || $uri === '/index.php') {
    $uri = '/';
}
$method = $_SERVER['REQUEST_METHOD'];
$router->route($uri, $method);
