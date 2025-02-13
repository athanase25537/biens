<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

// Adapters
use App\Adapter\Persistence\MySQLAdapter;
use App\Adapter\Persistence\PostgreSQLAdapter;
use App\Route\Router;
use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;
use App\Adapter\Api\Rest\EtatLieuxController;
use App\Adapter\Api\Rest\EtatLieuxItemsController;
use App\Adapter\Api\Rest\IncidentController;
use App\Adapter\Api\Rest\QuittanceLoyerController;
use App\Adapter\Api\Rest\SuiviController;
use App\Adapter\Api\Rest\UserAbonnementController;
use App\Core\Application\UseCase\UserAbonnement\CreateUserAbonnementUseCase;
use App\Core\Application\UseCase\UserAbonnement\UpdateUserAbonnementUseCase;
use App\Core\Application\UseCase\Suivi\CreateSuiviUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\CreateQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\SelectLastQuittanceByBailIdUseCase;
use App\Core\Application\UseCase\User\LoginUserUseCase;
use App\Core\Application\UseCase\User\RegisterUserUseCase;

use App\Core\Application\UseCase\BienImmobilier\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\DeleteBienImmobilierUseCase;

use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\UpdateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\DeleteTypeBienUseCase;

use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\UpdateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\DeleteEtatLieuxUseCase;

use App\Core\Application\UseCase\EtatLieuxItems\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\UpdateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\DeleteEtatLieuxItemsUseCase;

use App\Core\Application\UseCase\Incident\CreateIncidentUseCase;
use App\Core\Application\UseCase\Incident\UpdateIncidentUseCase;
use App\Core\Application\UseCase\Incident\DeleteIncidentUseCase;

// Repositories
use App\Adapter\Persistence\Doctrine\UserRepository;
use App\Adapter\Persistence\Doctrine\BienImmobilierRepository;
use App\Adapter\Persistence\Doctrine\TypeBienRepository;
use App\Adapter\Persistence\Doctrine\EtatLieuxRepository;
use App\Adapter\Persistence\Doctrine\EtatLieuxItemsRepository;
use App\Adapter\Persistence\Doctrine\IncidentRepository;
use App\Adapter\Persistence\Doctrine\QuittanceLoyerRepository;
use App\Adapter\Persistence\Doctrine\SuiviRepository;
use App\Adapter\Persistence\Doctrine\UserAbonnementRepository;

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
$userAbonnementRepository = new UserAbonnementRepository($dbAdapter);
$createUserAbonnementUseCase = new CreateUserAbonnementUseCase($userAbonnementRepository);
$updateUserAbonnementUserCase = new UpdateUserAbonnementUseCase($userAbonnementRepository);
$userAbonnement = new UserAbonnementController(
    $createUserAbonnementUseCase,
    $updateUserAbonnementUserCase
);

$suiviRepository = new SuiviRepository($dbAdapter);
$createSuiviUseCase = new CreateSuiviUseCase($suiviRepository);
$suivi = new SuiviController($createSuiviUseCase);

$quittanceLoyerRepository = new QuittanceLoyerRepository($dbAdapter);
$createQuittanceLoyerUseCase = new CreateQuittanceLoyerUseCase($quittanceLoyerRepository);
$selectLastQuittanceByBailIdUseCase = new SelectLastQuittanceByBailIdUseCase($quittanceLoyerRepository);
$quittanceLoyer = new QuittanceLoyerController(
    $createQuittanceLoyerUseCase,
    $selectLastQuittanceByBailIdUseCase
);

$incidentRepository = new IncidentRepository($dbAdapter);
$createIncidentUseCase = new CreateIncidentUseCase($incidentRepository);
$updateIncidentUseCase = new UpdateIncidentUseCase($incidentRepository);
$deleteIncidentUseCase = new DeleteIncidentUseCase($incidentRepository);
$incident = new IncidentController(
    $createIncidentUseCase,
    $updateIncidentUseCase,
    $deleteIncidentUseCase
);

$etatLieuxItemsRepository = new EtatLieuxItemsRepository($dbAdapter);
$createEtatLieuxItemsUseCase = new CreateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$updateEtatLieuxItemsUseCase = new UpdateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$deleteEtatLieuxItemsUseCase = new DeleteEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$etatLieuxItems = new EtatLieuxItemsController(
    $createEtatLieuxItemsUseCase,
    $updateEtatLieuxItemsUseCase,
    $deleteEtatLieuxItemsUseCase
);

$etatLieuxRepository = new EtatLieuxRepository($dbAdapter);
$createEtatLieuxUseCase = new CreateEtatLieuxUseCase($etatLieuxRepository);
$updateEtatLieuxUseCase = new UpdateEtatLieuxUseCase($etatLieuxRepository);
$deleteEtatLieuxUseCase = new DeleteEtatLieuxUseCase($etatLieuxRepository);
$etatLieux = new EtatLieuxController(
    $createEtatLieuxUseCase,
    $updateEtatLieuxUseCase,
    $deleteEtatLieuxUseCase,
);

$bienImmobilierRepository = new BienImmobilierRepository($dbAdapter);
$createBienImmobilierUseCase = new CreateBienImmobilierUseCase($bienImmobilierRepository);
$updateBienImmobilierUseCase = new UpdateBienImmobilierUseCase($bienImmobilierRepository);
$deleteBienImmobilierUseCase = new DeleteBienImmobilierUseCase($bienImmobilierRepository);
$bienImmobilier = new BienImmobilierController(
    $createBienImmobilierUseCase,
    $updateBienImmobilierUseCase,
    $deleteBienImmobilierUseCase,
);

$typeBienRepository = new TypeBienRepository($dbAdapter);
$createTypeBienUseCase = new CreateTypeBienUseCase($typeBienRepository);
$updateTypeBienUseCase = new UpdateTypeBienUseCase($typeBienRepository);
$deleteTypeBienUseCase = new DeleteTypeBienUseCase($typeBienRepository);
$typeBien = new TypeBienController(
    $createTypeBienUseCase,
    $updateTypeBienUseCase,
    $deleteTypeBienUseCase
);

// AuthController
$userRepository = new UserRepository($dbAdapter);
$loginUseCase = new LoginUserUseCase($userRepository);
$registerUseCase = new RegisterUserUseCase($userRepository);
$controller = new AuthController($registerUseCase, $loginUseCase);

$router = new Router();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Include the routes file
require_once '../src/Route/routes.php';
defineRoutes(
    $router, 
    $controller, 
    $userAbonnement, 
    $suivi, 
    $quittanceLoyer, 
    $incident, 
    $etatLieuxItems, 
    $etatLieux, 
    $bienImmobilier, 
    $typeBien
);

// Handle the request
$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);