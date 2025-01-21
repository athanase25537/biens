<?php

require_once '../vendor/autoload.php';

// adapters
use App\Adapter\Persistence\MySQLAdapter;
use App\Adapter\Persistence\PostgreSQLAdapter;

// controllers
use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;
use App\Adapter\Api\Rest\EtatLieuxController;
use App\Adapter\Api\Rest\EtatLieuxItemsController;
use App\Adapter\Api\Rest\IncidentController;

// useCases
use App\Core\Application\UseCase\LoginUserUseCase;
use App\Core\Application\UseCase\RegisterUserUseCase;
use App\Core\Application\UseCase\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\DeleteBienImmobilierUseCase;
use App\Core\Application\UseCase\CreateTypeBienUseCase;
use App\Core\Application\UseCase\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\UpdateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\CreateIncidentUseCase;

// repositories
use App\Adapter\Persistence\Doctrine\UserRepository;
use App\Adapter\Persistence\Doctrine\BienImmobilierRepository;
use App\Adapter\Persistence\Doctrine\TypeBienRepository;
use App\Adapter\Persistence\Doctrine\EtatLieuxRepository;
use App\Adapter\Persistence\Doctrine\EtatLieuxItemsRepository;
use App\Adapter\Persistence\Doctrine\IncidentRepository;

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

// Incident
$incidentRepository = new IncidentRepository($dbAdapter);
$createIncidentUseCase = new CreateIncidentUseCase($incidentRepository);

$incident = new IncidentController($createIncidentUseCase);

// Etats Lieux items
$etatLieuxItemsRepository = new EtatLieuxItemsRepository($dbAdapter);
$createEtatLieuxItemsUseCase = new CreateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$updateEtatLieuxItemsUseCase = new UpdateEtatLieuxItemsUseCase($etatLieuxItemsRepository);

$etatLieuxItems = new EtatLieuxItemsController($createEtatLieuxItemsUseCase, $updateEtatLieuxItemsUseCase);

// Etats lieux
$etatLieuxRepository = new EtatLieuxRepository($dbAdapter);
$createEtatLieuxUseCase = new CreateEtatLieuxUseCase($etatLieuxRepository);

$etatLieux = new EtatLieuxController(new CreateEtatLieuxUseCase($etatLieuxRepository));

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
} elseif ($requestUri === '/incident/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $incident->create();
} elseif ($requestUri === '/etat-lieux-items/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $etatLieuxItems->create();
} elseif (preg_match('#^/etat-lieux-items/update/(\d+)$#', $requestUri, $matches) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try{
        $etatLieuxItemsId = $matches[1];
        $etatLieuxItems->update($etatLieuxItemsId);
    } catch(Exception $e) {
        echo "Erreur: " . $e;
    }
} elseif ($requestUri === '/etat-lieux/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $etatLieux->create();
} elseif ($requestUri === '/bien-immobilier/create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
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