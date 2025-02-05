<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$price = \Stripe\Price::create([
    'unit_amount' => 1000, // Prix en cents (10.00€)
    'currency' => 'eur',
    'recurring' => ['interval' => 'month'], // Abonnement mensuel
    'product_data' => [
        'name' => 'Abonnement Premium',
    ],
]);

echo "Price ID : " . $price->id;
