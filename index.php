<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$requestUri = $_SERVER['REQUEST_URI'];

// Routes simples
if ($requestUri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/src/Adapter/Api/Rest/AuthController.php';
    $controller = new \App\Adapter\Api\Rest\AuthController();
    $controller->login();
} elseif ($requestUri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/src/Adapter/Api/Rest/AuthController.php';
    $controller = new \App\Adapter\Api\Rest\AuthController();
    $controller->register();
} else {
    http_response_code(404);
    echo "404 Not Found";
}
