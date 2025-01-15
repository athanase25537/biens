<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/autoload.php';
$dbConfig = require __DIR__ . '/config/database.php';

try {
    $dbAdapterClass = match ($dbConfig['db_type']) {
        'mysql' => \App\Adapter\Persistence\MySQLAdapter::class,
        'postgresql' => \App\Adapter\Persistence\PostgreSQLAdapter::class,
        'sqlite' => \App\Adapter\Persistence\SQLiteAdapter::class,
        'pdo' => \App\Adapter\Persistence\PDOAdapter::class,
        default => throw new \Exception("Unsupported database type: {$dbConfig['db_type']}"),
    };

    $dbAdapter = new $dbAdapterClass();
    $dbAdapter->connect($dbConfig);
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}

// Initialisation des dépendances
$userRepository = new \App\Adapter\Persistence\Doctrine\UserRepository($dbAdapter);
$loginUseCase = new \App\Core\Application\UseCase\LoginUserUseCase($userRepository);
$registerUseCase = new \App\Core\Application\UseCase\RegisterUserUseCase($userRepository);
$controller = new \App\Adapter\Api\Rest\AuthController($registerUseCase, $loginUseCase);

// Gestion des routes
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

try {
    if ($requestUri === '/login' && $requestMethod === 'POST') {
        $controller->login();
    } elseif ($requestUri === '/register' && $requestMethod === 'POST') {
        $controller->register();
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Not Found']);
    }
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}