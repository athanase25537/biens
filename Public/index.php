<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Chargement de la configuration
$dbConfig = require __DIR__ . '/../config/database.php';

// Création de l'adaptateur de base de données approprié
$dbAdapterClass = match($dbConfig['db_type']) {
    'mysql' => \App\Adapter\Persistence\Doctrine\DatabaseAdapter\MySQLAdapter::class,
    'postgresql' => \App\Adapter\Persistence\Doctrine\DatabaseAdapter\PostgreSQLAdapter::class,
    default => throw new \Exception("Unsupported database type: {$dbConfig['db_type']}")
};

$dbAdapter = new $dbAdapterClass();
$dbAdapter->connect($dbConfig);

// Initialisation des dépendances
$userRepository = new \App\Adapter\Persistence\Doctrine\UserRepository($dbAdapter);
$loginUseCase = new \App\Core\Application\UseCase\LoginUserUseCase($userRepository);
$registerUseCase = new \App\Core\Application\UseCase\RegisterUserUseCase($userRepository);
$controller = new \App\Adapter\Api\Rest\AuthController($registerUseCase, $loginUseCase);

// Gestion des routes
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} elseif ($requestUri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Not Found']);
}