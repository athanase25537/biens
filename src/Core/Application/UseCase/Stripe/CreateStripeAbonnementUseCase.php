<?php

/*
** configuration
* PUBLIQUE : pk_test_51OI9wrJyueeXhqQIYPnx4pkvabSQGrS2kHdtp0ov9R6zC0eK7cU7FFhyAdXZzdiBFydNsLAzmQ6RL6ZRlNnGkbH900b1pakkhY
*   SECRET : sk_test_51OI9wrJyueeXhqQIuM0r0JB0NSMVIdSd5WPX6wsLRr3Zzhx08jRDYQXVLFnw6CXDLo99HAQz3fGsh6ofuxx8JKf900w9BL4z3S
*/
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51OI9wrJyueeXhqQIuM0r0JB0NSMVIdSd5WPX6wsLRr3Zzhx08jRDYQXVLFnw6CXDLo99HAQz3fGsh6ofuxx8JKf900w9BL4z3S'); // Remplacez par votre clé API secrète

$customer = \Stripe\Customer::create([
    'email' => 'client@example.com',
    'payment_method' => 'pm_card_visa', // 4242 4242 4242 4242
    'invoice_settings' => ['default_payment_method' => 'pm_card_visa']
]);

$price = \Stripe\Price::create([
    'unit_amount' => 1000, // Prix en cents (10.00€)
    'currency' => 'eur',
    'recurring' => ['interval' => 'month'], // Abonnement mensuel
    'product_data' => [
        'name' => 'Abonnement Premium',
    ],
]);

$subscription = \Stripe\Subscription::create([
    'customer' => $customer->id,
    'items' => [[
        'price' => $price->id,
    ]],
    'expand' => ['latest_invoice.payment_intent'],
]);

$endpoint_secret = 'whsec_votre_secret_webhook';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );

    if ($event->type == 'invoice.payment_succeeded') {
        $subscription = $event->data->object;
        // Mettez à jour votre base de données ici
    }
} catch (\Exception $e) {
    http_response_code(400);
    exit();
}
http_response_code(200);
