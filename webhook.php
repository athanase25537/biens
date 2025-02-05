<?php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']); // Charge ta clé API depuis .env

$endpoint_secret = 'whsec_ton_secret_webhook'; // Remplace avec ton vrai secret Webhook

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

    switch ($event->type) {
        case 'invoice.payment_succeeded':
            $invoice = $event->data->object;
            error_log("✅ Paiement réussi pour l'abonnement : " . $invoice->subscription);
            break;
        case 'invoice.payment_failed':
            $invoice = $event->data->object;
            error_log("❌ Échec du paiement pour l'abonnement : " . $invoice->subscription);
            break;
        case 'customer.subscription.deleted':
            error_log("🔴 Abonnement annulé !");
            break;
        default:
            error_log("📌 Événement non géré : " . $event->type);
    }
} catch (\Exception $e) {
    error_log("🚨 Erreur Webhook : " . $e->getMessage());
    http_response_code(400);
    exit();
}

http_response_code(200);
