<?php

require_once '../vendor/autoload.php';

// adapters
use App\Adapter\Persistence\MySQLAdapter;
use App\Adapter\Persistence\PostgreSQLAdapter;

// route
use App\Route\Router;

// controllers
use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;
use App\Adapter\Api\Rest\EtatLieuxController;
use App\Adapter\Api\Rest\EtatLieuxItemsController;
use App\Adapter\Api\Rest\IncidentController;
use App\Adapter\Api\Rest\QuittanceLoyerController;
use App\Adapter\Api\Rest\SuiviController;
use App\Adapter\Api\Rest\UserAbonnementController;

// useCases

// user abonnement
use App\Core\Application\UseCase\UserAbonnement\CreateUserAbonnementUseCase;
// use App\Core\Application\UseCase\Suivi\UpdateSuiviUseCase;
// use App\Core\Application\UseCase\Suivi\DeleteSuiviUseCase;

// suivi
use App\Core\Application\UseCase\Suivi\CreateSuiviUseCase;
// use App\Core\Application\UseCase\Suivi\UpdateSuiviUseCase;
// use App\Core\Application\UseCase\Suivi\DeleteSuiviUseCase;

// quittance loyer
use App\Core\Application\UseCase\QuittanceLoyer\CreateQuittanceLoyerUseCase;
// use App\Core\Application\UseCase\QuittanceLoyer\UpdateQuittanceLoyerUseCase;
// use App\Core\Application\UseCase\QuittanceLoyer\DeleteQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\SelectLastQuittanceByBailIdUseCase;

// user
use App\Core\Application\UseCase\User\LoginUserUseCase;
use App\Core\Application\UseCase\User\RegisterUserUseCase;

// bien immobilier
use App\Core\Application\UseCase\BienImmobilier\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\DeleteBienImmobilierUseCase;

// type bien
use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\UpdateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\DeleteTypeBienUseCase;

// etat lieux
use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\UpdateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\DeleteEtatLieuxUseCase;

// etat lieux items
use App\Core\Application\UseCase\EtatLieuxItems\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\UpdateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\DeleteEtatLieuxItemsUseCase;

// incident
use App\Core\Application\UseCase\Incident\CreateIncidentUseCase;
use App\Core\Application\UseCase\Incident\UpdateIncidentUseCase;
use App\Core\Application\UseCase\Incident\DeleteIncidentUseCase;

// repositories
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

// User Abonnement
$userAbonnementRepository = new UserAbonnementRepository($dbAdapter);
$createUserAbonnementUseCase = new CreateUserAbonnementUseCase($userAbonnementRepository);
// $updateSuiviUseCase = new UpdateSuiviUseCase($suiviRepository);
// $deleteSuiviUseCase = new DeleteSuiviUseCase($suiviRepository);

$userAbonnement = new UserAbonnementController(
    $createUserAbonnementUseCase,
    // $updateSuiviUseCase,
    // $deleteSuiviUseCase,
);


// Suivi
$suiviRepository = new SuiviRepository($dbAdapter);
$createSuiviUseCase = new CreateSuiviUseCase($suiviRepository);
// $updateSuiviUseCase = new UpdateSuiviUseCase($suiviRepository);
// $deleteSuiviUseCase = new DeleteSuiviUseCase($suiviRepository);

$suivi = new SuiviController(
    $createSuiviUseCase,
    // $updateSuiviUseCase,
    // $deleteSuiviUseCase,
);

// Quittance Loyer
$quittanceLoyerRepository = new QuittanceLoyerRepository($dbAdapter);
$createQuittanceLoyerUseCase = new CreateQuittanceLoyerUseCase($quittanceLoyerRepository);
// $updateQuittanceLoyerUseCase = new UpdateQuittanceLoyerUseCase($quittanceLoyerRepository);
// $deleteQuittanceLoyerUseCase = new DeleteQuittanceLoyerUseCase($quittanceLoyerRepository);
$selectLastQuittanceByBailIdUseCase = new SelectLastQuittanceByBailIdUseCase($quittanceLoyerRepository);

$quittanceLoyer = new QuittanceLoyerController(
    $createQuittanceLoyerUseCase,
    // $updateQuittanceLoyerUseCase,
    // $deleteQuittanceLoyerUseCase,
    $selectLastQuittanceByBailIdUseCase
);

// Incident
$incidentRepository = new IncidentRepository($dbAdapter);
$createIncidentUseCase = new CreateIncidentUseCase($incidentRepository);
$updateIncidentUseCase = new UpdateIncidentUseCase($incidentRepository);
$deleteIncidentUseCase = new DeleteIncidentUseCase($incidentRepository);

$incident = new IncidentController(
    $createIncidentUseCase,
    $updateIncidentUseCase,
    $deleteIncidentUseCase,
);

// Etats Lieux items
$etatLieuxItemsRepository = new EtatLieuxItemsRepository($dbAdapter);
$createEtatLieuxItemsUseCase = new CreateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$updateEtatLieuxItemsUseCase = new UpdateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$deleteEtatLieuxItemsUseCase = new DeleteEtatLieuxItemsUseCase($etatLieuxItemsRepository);

$etatLieuxItems = new EtatLieuxItemsController(
    $createEtatLieuxItemsUseCase, 
    $updateEtatLieuxItemsUseCase,
    $deleteEtatLieuxItemsUseCase
);

// Etats lieux
$etatLieuxRepository = new EtatLieuxRepository($dbAdapter);
$createEtatLieuxUseCase = new CreateEtatLieuxUseCase($etatLieuxRepository);
$updateEtatLieuxUseCase = new UpdateEtatLieuxUseCase($etatLieuxRepository);
$deleteEtatLieuxUseCase = new DeleteEtatLieuxUseCase($etatLieuxRepository);

$etatLieux = new EtatLieuxController(
    $createEtatLieuxUseCase,
    $updateEtatLieuxUseCase,
    $deleteEtatLieuxUseCase
);

// bien immobilier
$bienImmobilierRepository = new BienImmobilierRepository($dbAdapter);
$createBienImmobilierUseCase = new CreateBienImmobilierUseCase($bienImmobilierRepository);
$updateBienImmobilierUseCase = new UpdateBienImmobilierUseCase($bienImmobilierRepository);
$deleteBienImmobilierUseCase = new DeleteBienImmobilierUseCase($bienImmobilierRepository);

$bienImmobilier = new BienImmobilierController($createBienImmobilierUseCase, $updateBienImmobilierUseCase, $deleteBienImmobilierUseCase);

// type bien
$typeBienRepository = new TypeBienRepository($dbAdapter);
$createTypeBienUseCase = new CreateTypeBienUseCase($typeBienRepository);
$updateTypeBienUseCase = new UpdateTypeBienUseCase($typeBienRepository);
$deleteTypeBienUseCase = new DeleteTypeBienUseCase($typeBienRepository);

$typeBien = new TypeBienController(
    $createTypeBienUseCase,
    $updateTypeBienUseCase,
    $deleteTypeBienUseCase
);

// user
$userRepository = new UserRepository($dbAdapter);
$loginUseCase = new LoginUserUseCase($userRepository);
$registerUseCase = new RegisterUserUseCase($userRepository);
$controller = new AuthController($registerUseCase, $loginUseCase);

$router = new Router();

// Define routes
$router->addRoute('POST', '#^/login$#', [$controller, 'login']);
$router->addRoute('POST', '#^/register$#', [$controller, 'register']);

// user abonnement
$router->addRoute('POST', '#^/user-abonnement/create$#', [$userAbonnement, 'create']);

// suivi
// $router->addRoute('PATCH', '#^/suivi-paiement/update/(\d+)$#', [$suivi, 'update']);
// $router->addRoute('DELETE', '#^/suivi-paiement/delete/(\d+)/(\d+)/(\d+)$#', [$suivi, 'destroy']);
$router->addRoute('POST', '#^/suivi-paiement/create$#', [$suivi, 'create']);

// quittance loyer
// $router->addRoute('PATCH', '#^/quittance-loyer/update/(\d+)$#', [$quittanceLoyer, 'update']);
// $router->addRoute('DELETE', '#^/quittance-loyer/delete/(\d+)/(\d+)/(\d+)$#', [$quittanceLoyer, 'destroy']);
$router->addRoute('POST', '#^/quittance-loyer/create$#', [$quittanceLoyer, 'create']);
$router->addRoute('GET', '#^/quittance-loyer/select-by-bail-id/(\d+)$#', [$quittanceLoyer, 'selectLastQuittanceByBailId']);

// incident
$router->addRoute('PATCH', '#^/incident/update/(\d+)$#', [$incident, 'update']);
$router->addRoute('DELETE', '#^/incident/delete/(\d+)/(\d+)/(\d+)$#', [$incident, 'destroy']);
$router->addRoute('POST', '#^/incident/create$#', [$incident, 'create']);

// etat lieux items
$router->addRoute('POST', '#^/etat-lieux-items/create$#', [$etatLieuxItems, 'create']);
$router->addRoute('POST', '#^/etat-lieux-items/update/(\d+)$#', [$etatLieuxItems, 'update']);
$router->addRoute('DELETE', '#^/etat-lieux-items/delete/(\d+)/(\d+)$#', [$etatLieuxItems, 'destroy']);

// etat lieux
$router->addRoute('POST', '#^/etat-lieux/create$#', [$etatLieux, 'create']);
$router->addRoute('PATCH', '#^/etat-lieux/update/(\d+)$#', [$etatLieux, 'update']);
$router->addRoute('DELETE', '#^/etat-lieux/delete/(\d+)/(\d+)$#', [$etatLieux, 'destroy']);

// bien immobilier
$router->addRoute('POST', '#^/bien-immobilier/create$#', [$bienImmobilier, 'create']);
$router->addRoute('POST', '#^/bien-immobilier/update/(\d+)$#', [$bienImmobilier, 'update']);

// type bien
$router->addRoute('POST', '#^/admin/type-bien/create$#', [$typeBien, 'create']);
$router->addRoute('PATCH', '#^/admin/type-bien/update/(\d+)$#', [$typeBien, 'update']);
$router->addRoute('DELETE', '#^/admin/type-bien/delete/(\d+)$#', [$typeBien, 'destroy']);

// Handle the request
$router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);