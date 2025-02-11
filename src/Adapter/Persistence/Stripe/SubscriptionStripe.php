<?php

namespace App\Adapter\Persistence\Stripe;

use Stripe\StripeClient;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class SubscriptionStripe
{
    private StripeClient $stripe;
    private string $endpointSecret;

    public function __construct(string $apiKey, string $endpointSecret)
    {
        \Stripe\Stripe::setApiKey('sk_test_51OI9wrJyueeXhqQIuM0r0JB0NSMVIdSd5WPX6wsLRr3Zzhx08jRDYQXVLFnw6CXDLo99HAQz3fGsh6ofuxx8JKf900w9BL4z3S');
        $this->stripe = new StripeClient($apiKey);
        $this->endpointSecret = $endpointSecret;
    }

    public function getStripe(): \Stripe\StripeClient
    {
        return $this->stripe;
    }

    public function createCustomer(string $email, string $name): \Stripe\Customer
    {
        return $this->stripe->customers->create([
            'email' => $email,
            'name' => $name,
        ]);
    }

    public function addPaymentMethod(string $paymentMethodId, string $customerId): void
    {
        $this->stripe->paymentMethods->attach($paymentMethodId, [
            'customer' => $customerId,
        ]);

        // Définir le moyen de paiement par défaut
        $this->stripe->customers->update($customerId, [
            'invoice_settings' => ['default_payment_method' => $paymentMethodId],
        ]);
    }

    public function createSubscription(string $customerId, string $priceId): \Stripe\Subscription
    {
        return $this->stripe->subscriptions->create([
            'customer' => $customerId,
            'items' => [['price' => $priceId]],
            'expand' => ['latest_invoice.payment_intent'],
        ]);
    }

    public function cancelSubscription(string $subscriptionId): \Stripe\Subscription
    {
        return $this->stripe->subscriptions->cancel($subscriptionId);
    }

    public function handleWebhook(string $payload, string $sigHeader): void
    {
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $this->endpointSecret);

            switch ($event->type) {
                case 'invoice.payment_succeeded':
                    $this->handleSuccessfulPayment($event->data->object);
                    break;
                case 'invoice.payment_failed':
                    $this->handleFailedPayment($event->data->object);
                    break;
                default:
                    // Autres événements non gérés
                    break;
            }
        } catch (UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        } catch (SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }

        http_response_code(200);
    }

    private function handleSuccessfulPayment($invoice): void
    {
        $customerId = $invoice->customer;
        // Logique pour activer l'abonnement ou envoyer un email
    }

    private function handleFailedPayment($invoice): void
    {
        $customerId = $invoice->customer;
        // Logique pour avertir l'utilisateur ou suspendre l'abonnement
    }
}
