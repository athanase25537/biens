<?php

use App\Core\Router;
use App\Core\Request;
use App\Controllers\AuthController;
use App\Controllers\PropertyController;

// require_once __DIR__ . '/vendor/autoload.php';

$router = new Router(new Request());


$router->post('/login', [AuthController::class, 'login']);
$router->post('/register', [AuthController::class, 'register']);


$router->resolve();
