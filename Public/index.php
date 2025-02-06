<?php

require_once '../vendor/autoload.php';

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
use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\UpdateTypeBienUseCase;
use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\Incident\CreateIncidentUseCase;

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
$incident = new IncidentController($createIncidentUseCase);

$etatLieuxItemsRepository = new EtatLieuxItemsRepository($dbAdapter);
$createEtatLieuxItemsUseCase = new CreateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$etatLieuxItems = new EtatLieuxItemsController($createEtatLieuxItemsUseCase);

$etatLieuxRepository = new EtatLieuxRepository($dbAdapter);
$createEtatLieuxUseCase = new CreateEtatLieuxUseCase($etatLieuxRepository);
$etatLieux = new EtatLieuxController($createEtatLieuxUseCase);

$bienImmobilierRepository = new BienImmobilierRepository($dbAdapter);
$createBienImmobilierUseCase = new CreateBienImmobilierUseCase($bienImmobilierRepository);
$bienImmobilier = new BienImmobilierController($createBienImmobilierUseCase);

$typeBienRepository = new TypeBienRepository($dbAdapter);
$createTypeBienUseCase = new CreateTypeBienUseCase($typeBienRepository);
$typeBien = new TypeBienController($createTypeBienUseCase);

// AuthController
$userRepository = new UserRepository($dbAdapter);
$loginUseCase = new LoginUserUseCase($userRepository);
$registerUseCase = new RegisterUserUseCase($userRepository);
$controller = new AuthController($registerUseCase, $loginUseCase);

$router = new Router();

// Include the routes file
require_once '../src/Route/routes.php';

// Handle the request
$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);