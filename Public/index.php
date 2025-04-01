<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';
// Adapters
use App\Adapter\Persistence\MySQLAdapter;
use App\Adapter\Persistence\PostgreSQLAdapter;
use App\Route\Router;

// Services
use App\Adapter\Persistence\Doctrine\HistoriqueModificationRepository;
use App\Core\Application\Service\HistoriqueService;


// Controllers
use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;
use App\Adapter\Api\Rest\EtatLieuxController;
use App\Adapter\Api\Rest\EtatLieuxItemsController;
use App\Adapter\Api\Rest\IncidentController;
use App\Adapter\Api\Rest\QuittanceLoyerController;
use App\Adapter\Api\Rest\SuiviController;
use App\Adapter\Api\Rest\UserAbonnementController;
use App\Adapter\Api\Rest\BailController;
use App\Adapter\Api\Rest\MailJetController;
use App\Adapter\Api\Rest\RecaptchaController;

// UseCases

// Recaptcha
use App\Core\Application\UseCase\Recaptcha\RecaptchaFormUseCase;
use App\Core\Application\UseCase\Recaptcha\RecaptchaCheckUseCase;

// Bail
use App\Core\Application\UseCase\Bail\AddBailUseCase;
use App\Core\Application\UseCase\Bail\UpdateBailUseCase;
use App\Core\Application\UseCase\Bail\DeleteBailUseCase;
use App\Core\Application\UseCase\Bail\GetAllBailUseCase;
use App\Core\Application\UseCase\SendNotificationUseCase;


// UserAbonnement
use App\Core\Application\UseCase\UserAbonnement\CreateUserAbonnementUseCase;
use App\Core\Application\UseCase\UserAbonnement\UpdateUserAbonnementUseCase;
use App\Core\Application\UseCase\UserAbonnement\DeleteUserAbonnementUseCase;

// Suivi
use App\Core\Application\UseCase\Suivi\CreateSuiviUseCase;
use App\Core\Application\UseCase\Suivi\UpdateSuiviUseCase;
use App\Core\Application\UseCase\Suivi\DeleteSuiviUseCase;

// Quittance Loyer
use App\Core\Application\UseCase\QuittanceLoyer\CreateQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\UpdateQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\SelectLastQuittanceByBailIdUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\DeleteQuittanceLoyerUseCase;


// Login
use App\Core\Application\UseCase\User\LoginUserUseCase;
use App\Core\Application\UseCase\User\RegisterUserUseCase;
use App\Core\Application\UseCase\User\AuthGoogleUseCase;

// Bien Immobilier
use App\Core\Application\UseCase\BienImmobilier\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\GetAllBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\DeleteBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\GetBienImmobilierUseCase;

// Type Bien
use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\UpdateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\DeleteTypeBienUseCase;

// Etat Lieux
use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\UpdateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\GetAllEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\DeleteEtatLieuxUseCase;

// Etat Lieux Items
use App\Core\Application\UseCase\EtatLieuxItems\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\UpdateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\DeleteEtatLieuxItemsUseCase;

// Incident
use App\Core\Application\UseCase\Incident\CreateIncidentUseCase;
use App\Core\Application\UseCase\Incident\UpdateIncidentUseCase;
use App\Core\Application\UseCase\Incident\GetAllIncidentUseCase;
use App\Core\Application\UseCase\Incident\DeleteIncidentUseCase;

// MailJet
use App\Core\Application\UseCase\MailJet\MailJetUseCase;

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
use App\Adapter\Persistence\Doctrine\BailRepository;
use App\Adapter\Persistence\Doctrine\NotificationRepository;


// Twig
use App\Controller\HomeController;

// Chargement de la configuration
$dbConfig = require __DIR__ . '/../config/database.php';

// Charge .env file
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Création de l'adaptateur de base de données approprié
$dbAdapterClass = match($dbConfig['db_type']) {
    'mysql' => MySQLAdapter::class,
    'postgresql' => PostgreSQLAdapter::class,
    default => throw new \Exception("Unsupported database type: {$dbConfig['db_type']}")
};

$dbAdapter = new $dbAdapterClass();
$dbAdapter = $dbAdapter->connect($dbConfig);

// Initialisation des dépendances

// Recaptcha
$recaptchaFormUseCase = new RecaptchaFormUseCase($_ENV['RECAPTCHA_SITE_KEY']);
$recaptchaCheckUseCase = new RecaptchaCheckUseCase($_ENV['RECAPTCHA_SECRET_KEY']);
$recaptcha = new RecaptchaController($recaptchaFormUseCase, $recaptchaCheckUseCase);

// Historique Services
$historiqueModificationRepository = new HistoriqueModificationRepository($dbAdapter);
$historiqueService = new HistoriqueService($historiqueModificationRepository);


// Bail
$bailRepository = new BailRepository($dbAdapter);
$notificationRepository = new NotificationRepository($dbAdapter);

$addBailUseCase = new AddBailUseCase($bailRepository, $historiqueService);
$updateBailUseCase = new UpdateBailUseCase($bailRepository, $historiqueService);
$getAllBailUseCase = new getAllBailUseCase($bailRepository);
$deleteBailUseCase = new DeleteBailUseCase($bailRepository, $historiqueService);
$sendNotificationUseCase = new SendNotificationUseCase($notificationRepository);

$bail = new BailController(
    $addBailUseCase,
    $updateBailUseCase,
    $getAllBailUseCase, 
    $deleteBailUseCase,
    $sendNotificationUseCase
);


// User Abonnement
$userAbonnementRepository = new UserAbonnementRepository($dbAdapter);
$createUserAbonnementUseCase = new CreateUserAbonnementUseCase($userAbonnementRepository);
$updateUserAbonnementUseCase = new UpdateUserAbonnementUseCase($userAbonnementRepository);
$deleteUserAbonnementUseCase = new DeleteUserAbonnementUseCase($userAbonnementRepository);
$userAbonnement = new UserAbonnementController(
    $createUserAbonnementUseCase,
    $updateUserAbonnementUseCase,
    $deleteUserAbonnementUseCase
);

// Suivi
$suiviRepository = new SuiviRepository($dbAdapter);
$createSuiviUseCase = new CreateSuiviUseCase($suiviRepository);
$updateSuiviUseCase = new UpdateSuiviUseCase($suiviRepository);
$deleteSuiviUseCase = new DeleteSuiviUseCase($suiviRepository);
$suivi = new SuiviController(
    $createSuiviUseCase,
    $updateSuiviUseCase,
    $deleteSuiviUseCase
);

// Quittance Loyer
$quittanceLoyerRepository = new QuittanceLoyerRepository($dbAdapter);
$createQuittanceLoyerUseCase = new CreateQuittanceLoyerUseCase($quittanceLoyerRepository);
$updateQuittanceLoyerUseCase = new UpdateQuittanceLoyerUseCase($quittanceLoyerRepository);
$deleteQuittanceLoyerUseCase = new DeleteQuittanceLoyerUseCase($quittanceLoyerRepository);
$selectLastQuittanceByBailIdUseCase = new SelectLastQuittanceByBailIdUseCase($quittanceLoyerRepository);
$quittanceLoyer = new QuittanceLoyerController(
    $createQuittanceLoyerUseCase,
    $updateQuittanceLoyerUseCase,
    $deleteQuittanceLoyerUseCase,
    $selectLastQuittanceByBailIdUseCase
);

// Incident
$incidentRepository = new IncidentRepository($dbAdapter);
$createIncidentUseCase = new CreateIncidentUseCase($incidentRepository);
$updateIncidentUseCase = new UpdateIncidentUseCase($incidentRepository);
$getAllIncidentUseCase = new GetAllIncidentUseCase($incidentRepository);
$deleteIncidentUseCase = new DeleteIncidentUseCase($incidentRepository);
$incident = new IncidentController(
    $createIncidentUseCase,
    $updateIncidentUseCase,
    $getAllIncidentUseCase,
    $deleteIncidentUseCase
);

// Etat des Lieux Items
$etatLieuxItemsRepository = new EtatLieuxItemsRepository($dbAdapter);
$createEtatLieuxItemsUseCase = new CreateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$updateEtatLieuxItemsUseCase = new UpdateEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$deleteEtatLieuxItemsUseCase = new DeleteEtatLieuxItemsUseCase($etatLieuxItemsRepository);
$etatLieuxItems = new EtatLieuxItemsController(
    $createEtatLieuxItemsUseCase,
    $updateEtatLieuxItemsUseCase,
    $deleteEtatLieuxItemsUseCase
);

// Etat des lieux
$etatLieuxRepository = new EtatLieuxRepository($dbAdapter);
$createEtatLieuxUseCase = new CreateEtatLieuxUseCase($etatLieuxRepository);
$updateEtatLieuxUseCase = new UpdateEtatLieuxUseCase($etatLieuxRepository);
$getAllEtatLieuxUseCase = new GetAllEtatLieuxUseCase($etatLieuxRepository);
$deleteEtatLieuxUseCase = new DeleteEtatLieuxUseCase($etatLieuxRepository);
$etatLieux = new EtatLieuxController(
    $createEtatLieuxUseCase,
    $updateEtatLieuxUseCase,
    $getAllEtatLieuxUseCase,
    $deleteEtatLieuxUseCase,
);

// Bien immobilier
$bienImmobilierRepository = new BienImmobilierRepository($dbAdapter);
$createBienImmobilierUseCase = new CreateBienImmobilierUseCase($bienImmobilierRepository);
$updateBienImmobilierUseCase = new UpdateBienImmobilierUseCase($bienImmobilierRepository);
$getAllBienImmobilierUseCase = new GetAllBienImmobilierUseCase($bienImmobilierRepository);
$deleteBienImmobilierUseCase = new DeleteBienImmobilierUseCase($bienImmobilierRepository);
$getBienImmobilierUseCase = new GetBienImmobilierUseCase($bienImmobilierRepository);
$bienImmobilier = new BienImmobilierController(
    $createBienImmobilierUseCase,
    $updateBienImmobilierUseCase,
    $getAllBienImmobilierUseCase,
    $deleteBienImmobilierUseCase,
    $getBienImmobilierUseCase,
);

// Type Bien
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

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'authGoogleConfig.php';
$authGoogleUseCase = new AuthGoogleUseCase($client);
$controller = new AuthController(
    $registerUseCase, 
    $loginUseCase,
    $authGoogleUseCase
);

// MailJet
$mailJetUseCase = new MailJetUseCase($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE']);
$mailJet = new MailJetController($mailJetUseCase);

$router = new Router();

// Instanciez le contrôleur d'accueil en utilisant la même casse partout
$homeController = new HomeController();

// Include the routes file
require_once '../src/Route/routes.php';
defineRoutes(
    $router, 
	$homeController,
    $controller, 
    $userAbonnement, 
    $suivi, 
    $quittanceLoyer, 
    $incident, 
    $etatLieuxItems, 
    $etatLieux, 
    $bienImmobilier, 
    $typeBien,
    $bail,
    $mailJet,
    $recaptcha
);

// Handle the request
try {
    $router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch(\Exception $e) {
    echo "Erreur: " . $e->getMessage();
    exit();
}