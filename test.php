<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$customer = \Stripe\Customer::create([
    'email' => 'client@example.com',
    'payment_method' => 'pm_card_visa', // Utilisation d'un moyen de paiement de test
    'invoice_settings' => ['default_payment_method' => 'pm_card_visa']
]);

echo "Client créé : " . $customer->id;

$subscription = \Stripe\Subscription::create([
    'customer' => $customer->id,
    'items' => [[
        'price' => 'price_1QorkEJyueeXhqQIbKDjOlGW', // Remplace par l'ID d'un prix existant
    ]],
    'expand' => ['latest_invoice.payment_intent'],
]);

echo "Abonnement créé : " . $subscription->id;

$endpoint_secret = 'whsec_ton_secret_webhook';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

    switch ($event->type) {
        case 'invoice.payment_succeeded':
            $invoice = $event->data->object;
            error_log("✅ Paiement réussi pour l'abonnement " . $invoice->subscription);
            break;
        case 'invoice.payment_failed':
            $invoice = $event->data->object;
            error_log("❌ Échec du paiement pour l'abonnement " . $invoice->subscription);
            break;
        case 'customer.subscription.deleted':
            error_log("🔴 Abonnement annulé !");
            break;
        default:
            error_log("Événement non géré : " . $event->type);
    }
} catch (\Exception $e) {
    error_log("Erreur Webhook : " . $e->getMessage());
    http_response_code(400);
    exit();
}

http_response_code(200);

