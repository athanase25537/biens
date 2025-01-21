<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'autoload.php';

// adapters
use App\Adapter\Persistence\MySQLAdapter;
use App\Adapter\Persistence\PostgreSQLAdapter;

// controllers
use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;
use App\Adapter\Api\Rest\BailController;
use App\Adapter\Api\Rest\MediaController;

// useCases
use App\Core\Application\UseCase\LoginUserUseCase;
use App\Core\Application\UseCase\RegisterUserUseCase;
use App\Core\Application\UseCase\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\DeleteBienImmobilierUseCase;
use App\Core\Application\UseCase\CreateTypeBienUseCase;
use App\Core\Application\UseCase\AddBailUseCase;
use App\Core\Application\UseCase\UploadMediaUseCase;

// repositories
use App\Adapter\Persistence\Doctrine\UserRepository;
use App\Adapter\Persistence\Doctrine\BienImmobilierRepository;
use App\Adapter\Persistence\Doctrine\TypeBienRepository;
use App\Adapter\Persistence\Doctrine\BailRepository;
use App\Adapter\Persistence\Doctrine\MediaRepository;

// Chargement de la configuration
$dbConfig = require __DIR__ . '/config/database.php';

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
$updateBienImmobilierUseCase = new UpdateBienImmobilierUseCase($bienImmobilierRepository);
$deleteBienImmobilierUseCase = new DeleteBienImmobilierUseCase($bienImmobilierRepository);

$bienImmobilier = new BienImmobilierController($createBienImmobilierUseCase, $updateBienImmobilierUseCase, $deleteBienImmobilierUseCase);

// type bien
$typeBienRepository = new TypeBienRepository($dbAdapter);
$createTypeBienUseCase = new CreateTypeBienUseCase($typeBienRepository);
$typeBien = new TypeBienController($createTypeBienUseCase);
// Bau
$bailRepository = new BailRepository($dbAdapter);
$createBail = new AddBailUseCase($bailRepository);
$bailController = new BailController($createBail);


// user
$userRepository = new UserRepository($dbAdapter);
$loginUseCase = new LoginUserUseCase($userRepository);
$registerUseCase = new RegisterUserUseCase($userRepository);
$controller = new AuthController($registerUseCase, $loginUseCase);

// Media
$mediaRepository = new MediaRepository($dbAdapter);
$uploadMediaUseCase = new UploadMediaUseCase($mediaRepository);
$mediaController = new MediaController($uploadMediaUseCase);

// Gestion des routes
$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} elseif ($requestUri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->register();
} elseif ($requestUri === '/bail/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $bailController->create();
}if ($requestUri === '/media/upload' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $mediaController->upload();
}
elseif ($requestUri === '/bien-immobilier/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $bienImmobilier->create();
} elseif (preg_match('#^/bien-immobilier/update/(\d+)$#', $requestUri, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
// } elseif ($requestUri === '/bien-immobilier/update/{id_proprietaire}/{id_bien}' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $idBien = $matches[1];
    try{
        $bienImmobilier->update($idBien);
    } catch(Exception $e) {
        echo "Erreur: " . $e;
    }
} elseif (preg_match('#^/bien-immobilier/delete/(\d+)$#', $requestUri, $matches) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $idBien = $matches[1];
    try{
        $bienImmobilier->destroy($idBien);
    } catch(Exception $e) {
        echo "Erreur: " . $e;
    }
} elseif ($requestUri === '/admin/type-bien/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $typeBien->create();
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Not Found']);
} 