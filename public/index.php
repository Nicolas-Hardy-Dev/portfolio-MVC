<?php

use App\Autoloader;
use App\Core\Router;

session_start();

require __DIR__ . '/../Autoloader.php';
Autoloader::register();

$route = new Router();

$route->routes(); 