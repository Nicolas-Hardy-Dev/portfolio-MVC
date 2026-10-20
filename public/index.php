<?php

use App\Autoloader;
use App\Core\Router;

require __DIR__ . '/../Autoloader.php';
Autoloader::register();

$route = new Router();

$route->routes(); 