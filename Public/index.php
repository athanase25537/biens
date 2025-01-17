<?php

require_once '../vendor/autoload.php';

// adapters
use App\Adapter\Persistence\MySQLAdapter;
use App\Adapter\Persistence\PostgreSQLAdapter;

// controllers
use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;

// useCases
use App\Core\Application\UseCase\LoginUserUseCase;
use App\Core\Application\UseCase\RegisterUserUseCase;
use App\Core\Application\UseCase\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\CreateTypeBienUseCase;

// repositories
use App\Adapter\Persistence\Doctrine\UserRepository;
use App\Adapter\Persistence\Doctrine\BienImmobilierRepository;
use App\Adapter\Persistence\Doctrine\TypeBienRepository;

// Chargement de la configuration
$dbConfig = require __DIR__ . '/../config/database.php';

// Création de l'adaptateur de base de données approprié
$dbAdapterClass = match($dbConfig['db_type']) {
    'mysql' => MySQLAdapter::class,
    'postgresql' => PostgreSQLAdapter::class,
    default => throw new \Exception("Unsupported database type: {$dbConfig['db_type']}")
};

$dbAdapter = new $dbAdapterClass();
$dbAdapter->connect($dbConfig);

// Initialisation des dépendances

// bien immobilier
$bienImmobilierRepository = new BienImmobilierRepository($dbAdapter);
$createBienImmobilierUseCase = new CreateBienImmobilierUseCase($bienImmobilierRepository);
$bienImmobilier = new BienImmobilierController($createBienImmobilierUseCase);

// type bien
$typeBienRepository = new TypeBienRepository($dbAdapter);
$createTypeBienUseCase = new CreateTypeBienUseCase($typeBienRepository);
$typeBien = new TypeBienController($createTypeBienUseCase);

// user
$userRepository = new UserRepository($dbAdapter);
$loginUseCase = new LoginUserUseCase($userRepository);
$registerUseCase = new RegisterUserUseCase($userRepository);
$controller = new AuthController($registerUseCase, $loginUseCase);

// Gestion des routes
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} elseif ($requestUri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} elseif ($requestUri === '/bien-immobilier/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $bienImmobilier->create();
// } elseif ($requestUri === '/bien-immobilier/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
//     $bienImmobilier->update();
// } elseif ($requestUri === '/bien-immobilier/delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
//     $bienImmobilier->destroy();
} elseif ($requestUri === '/admin/type-bien/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $typeBien->create();
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Not Found']);
} 