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

$apiKey = $_ENV['STRIPE_SECRET_KEY'];
$endPointKey = $_ENV['SECRET_KEY'];
\Stripe\Stripe::setApiKey($apiKey);

$stripeService = new SubscriptionStripe(
    $apiKey,
    $endPointKey
);

try {
    // 1. Créer le client
    $customer = $stripeService->createCustomer('client@example.com', 'Jenny Rosen');

    // 2. Définir un moyen de paiement valide
    $paymentMethods = $stripeService->getStripe()->paymentMethods->create([
        'type' => 'card',
        'card' => [
            'token' => 'tok_visa'
        ],
        'billing_details' => ['name' => 'Jenny Rosen'],
      ]);

    $paymentMethodId = $paymentMethods->id; 

    // 3. Vérifier et attacher le moyen de paiement au client
    $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
    if ($paymentMethod) {
        $paymentMethod->attach(['customer' => $customer->id]);
    } else {
        throw new Exception("Le moyen de paiement est introuvable.");
    }

    // 4. Définir le moyen de paiement par défaut
    \Stripe\Customer::update($customer->id, [
        'invoice_settings' => ['default_payment_method' => $paymentMethodId]
    ]);

    // 5. Créer l'abonnement
    $price = 'price_1QorkEJyueeXhqQIbKDjOlGW';
    $subscription = $stripeService->createSubscription($customer->id, $price);
    
    echo "Abonnement créé avec succès !";

} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// Define routes
function defineRoutes(
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
) {
    // Auth routes
    $router->addRoute('POST', '#^/login$#', [$controller, 'login']);
    $router->addRoute('POST', '#^/register$#', [$controller, 'register']);

    // User Abonnement routes
    $router->addRoute('POST', '#^/user-abonnement/create$#', [$userAbonnement, 'create']);
    $router->addRoute('PATCH', '#^/user-abonnement/update/(\d+)$#', [$userAbonnement, 'update']);

    // Suivi routes
    $router->addRoute('POST', '#^/suivi-paiement/create$#', [$suivi, 'create']);

    // Quittance Loyer routes
    $router->addRoute('POST', '#^/quittance-loyer/create$#', [$quittanceLoyer, 'create']);
    $router->addRoute('GET', '#^/quittance-loyer/select-by-bail-id/(\d+)$#', [$quittanceLoyer, 'selectLastQuittanceByBailId']);

    // Incident routes
    $router->addRoute('PATCH', '#^/incident/update/(\d+)$#', [$incident, 'update']);
    $router->addRoute('DELETE', '#^/incident/delete/(\d+)/(\d+)/(\d+)$#', [$incident, 'destroy']);
    $router->addRoute('POST', '#^/incident/create$#', [$incident, 'create']);

    // Etat Lieux Items routes
    $router->addRoute('POST', '#^/etat-lieux-items/create$#', [$etatLieuxItems, 'create']);
    $router->addRoute('POST', '#^/etat-lieux-items/update/(\d+)$#', [$etatLieuxItems, 'update']);
    $router->addRoute('DELETE', '#^/etat-lieux-items/delete/(\d+)/(\d+)$#', [$etatLieuxItems, 'destroy']);

    // Etat Lieux routes
    $router->addRoute('POST', '#^/etat-lieux/create$#', [$etatLieux, 'create']);
    $router->addRoute('PATCH', '#^/etat-lieux/update/(\d+)$#', [$etatLieux, 'update']);
    $router->addRoute('DELETE', '#^/etat-lieux/delete/(\d+)/(\d+)$#', [$etatLieux, 'destroy']);

    // Bien Immobilier routes
    $router->addRoute('POST', '#^/bien-immobilier/create$#', [$bienImmobilier, 'create']);
    $router->addRoute('POST', '#^/bien-immobilier/update/(\d+)$#', [$bienImmobilier, 'update']);

    // Type Bien routes
    $router->addRoute('POST', '#^/admin/type-bien/create$#', [$typeBien, 'create']);
    $router->addRoute('PATCH', '#^/admin/type-bien/update/(\d+)$#', [$typeBien, 'update']);
    $router->addRoute('DELETE', '#^/admin/type-bien/delete/(\d+)$#', [$typeBien, 'destroy']);
}