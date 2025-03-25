<?php
// routes.php

use App\Adapter\Api\Rest\AuthController;
use App\Adapter\Api\Rest\BienImmobilierController;
use App\Adapter\Api\Rest\TypeBienController;
use App\Adapter\Api\Rest\EtatLieuxController;
use App\Adapter\Api\Rest\EtatLieuxItemsController;
use App\Adapter\Api\Rest\IncidentController;
use App\Adapter\Api\Rest\QuittanceLoyerController;
use App\Adapter\Api\Rest\SuiviController;
use App\Adapter\Api\Rest\UserAbonnementController;
use App\Adapter\Persistence\Stripe\SubscriptionStripe;
use App\Adapter\Api\Rest\MailJetController;

use App\Controller\HomeController;


$homeController = new HomeController();


// Define routes
function defineRoutes(
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
) {
	
    $link = '/api';

    // Recaptcha routes
    $router->addRoute('GET', $link.'/recaptcha', [$recaptcha, 'recaptcha']);
    $router->addRoute('POST', $link.'/recaptcha-check', [$recaptcha, 'recaptchaCheck']);

    // Recaptcha routes
    $router->addRoute('GET', $link.'/recaptcha', [$recaptcha, 'recaptcha']);
    $router->addRoute('POST', $link.'/recaptcha-check', [$recaptcha, 'recaptchaCheck']);

    // Recaptcha routes
    $router->addRoute('GET', $link.'/recaptcha$#', [$recaptcha, 'recaptcha']);
    $router->addRoute('POST', $link.'/recaptcha-check$#', [$recaptcha, 'recaptchaCheck']);

    // Auth routes
    $router->addRoute('POST', $link.'/verify', [$controller, 'login']);
    $router->addRoute('POST', $link.'/save', [$controller, 'register']);
    
    // Auth Google routes
    $router->addRoute('GET', $link. '/auth-google', [$controller, 'auth_google']);
    $router->addRoute('GET', $link. '/auth-google-check', [$controller, 'auth_google_check']);
    // $router->addRoute('POST', $link.'/logout', [$controller, 'logout']);

    // User Abonnement routes
    $router->addRoute('POST', $link.'/user-abonnement/create', [$userAbonnement, 'create']);
    $router->addRoute('PATCH', $link.'/user-abonnement/update/(\d+)', [$userAbonnement, 'update']);

    // Suivi routes
    $router->addRoute('POST', $link.'/suivi-paiement/create', [$suivi, 'create']);

    // Quittance Loyer routes
    $router->addRoute('POST', $link.'/quittance-loyer/create', [$quittanceLoyer, 'create']);
    $router->addRoute('PATCH', $link.'/quittance-loyer/update/(\d+)', [$quittanceLoyer, 'update']);
    $router->addRoute('GET', $link.'/quittance-loyer/select-by-bail-id/(\d+)', [$quittanceLoyer, 'selectLastQuittanceByBailId']);

    // Incident routes
    $router->addRoute('PATCH', $link.'/incident/update/(\d+)', [$incident, 'update']);
    $router->addRoute('DELETE', $link.'/incident/delete/(\d+)/(\d+)/(\d+)', [$incident, 'destroy']);
    $router->addRoute('POST', $link.'/incident/create', [$incident, 'create']);
    $router->addRoute('GET', $link.'/incident/get-all/(\d+)', [$incident, 'getAll']);

    // Etat Lieux Items routes
    $router->addRoute('POST', $link.'/etat-lieux-items/create', [$etatLieuxItems, 'create']);
    $router->addRoute('PATCH', $link.'/etat-lieux-items/update/(\d+)', [$etatLieuxItems, 'update']);
    $router->addRoute('DELETE', $link.'/etat-lieux-items/delete/(\d+)/(\d+)', [$etatLieuxItems, 'destroy']);

    // Etat Lieux routes
    $router->addRoute('POST', $link.'/etat-lieux/create', [$etatLieux, 'create']);
    $router->addRoute('GET', $link.'/etat-lieux/get-all/(\d+)', [$etatLieux, 'getAll']);
    $router->addRoute('PATCH', $link.'/etat-lieux/update/(\d+)', [$etatLieux, 'update']);
    $router->addRoute('DELETE', $link.'/etat-lieux/delete/(\d+)/(\d+)', [$etatLieux, 'destroy']);

    // Bien Immobilier routes
    $router->addRoute('GET', $link.'/bien-immobilier/get-all/(\d+)', [$bienImmobilier, 'getAll']);
    $router->addRoute('POST', $link.'/bien-immobilier/create', [$bienImmobilier, 'create']);
    $router->addRoute('PATCH', $link.'/bien-immobilier/update/(\d+)', [$bienImmobilier, 'update']);
    $router->addRoute('DELETE', '/bien-immobilier/delete/(\d+)', [$bienImmobilier, 'destroy']);

    // Type Bien routes
    $router->addRoute('POST', '/admin/type-bien/create', [$typeBien, 'create']);
    $router->addRoute('PATCH', '/admin/type-bien/update/(\d+)', [$typeBien, 'update']);
    $router->addRoute('DELETE', '/admin/type-bien/delete/(\d+)', [$typeBien, 'destroy']);
	
    // Baux routes
    $router->addRoute('GET', $link.'/bail/get-all/(\d+)', [$bail, 'getAll']);

	// Page d'accueil (GET /)
	$router->addRoute('GET', '/', [$homeController, 'index']);

    // Login template
    $router->addRoute('GET', '/login', [$homeController, 'login']);

    // Register template
    $router->addRoute('GET', '/register', [$homeController, 'register']);

    // Mail Jet
	$router->addRoute('POST', $link.'/mailjet/send-message', [$mailJet, 'sendMessage']);
}