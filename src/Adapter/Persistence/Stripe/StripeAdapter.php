<?php

namespace App\Adapter\Persistence\Stripe;

use App\Port\Out\StripeAdapterInterface;
use Stripe\Stripe;

class StripeAdapter implements StripeAdapterInterface
{

    private StripeClient $stripe;
    private string $endpointSecret;
    private string $sigHeader;
    private string $payload; 
    public function __construct(string $apiKey, string $clientKey, string $endpointSecret)
    {
        \Stripe\Stripe::setApiKey($apiKey);
        $this->stripe = new \Stripe\StripeClient($clientKey);
        $this->endpointSecret = $endpointSecret;
        $this->sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $this->payload = @file_get_contents('php://input');
    }

    public function event(): \Stripe\Event
    {
        $event = null;
        try {
            $event = \Stripe\Webhook::constructEvent(
                $this->payload, $this->sigHeader, $this->endpointSecret
            );
            
            return $event;

        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);    
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
    }

    // switch ($event->type) {
    // case 'subscription_schedule.aborted':
    //     $subscriptionSchedule = $event->data->object;
    // case 'subscription_schedule.canceled':
    //     $subscriptionSchedule = $event->data->object;
    // case 'subscription_schedule.completed':
    //     $subscriptionSchedule = $event->data->object;
    // case 'subscription_schedule.created':
    //     $subscriptionSchedule = $event->data->object;
    // case 'subscription_schedule.expiring':
    //     $subscriptionSchedule = $event->data->object;
    // case 'subscription_schedule.released':
    //     $subscriptionSchedule = $event->data->object;
    // case 'subscription_schedule.updated':
    //     $subscriptionSchedule = $event->data->object;
    // // ... handle other event types
    // default:
    //     echo 'Received unknown event type ' . $event->type;
    // }

    // http_response_code(200); 

    public function createSubscription($name, $email): \Stripe\Subscription
    {
        $customer = createCustomer($name, $email);
        $subscription = \Stripe\Subscription::create([
            'customer' => $customer->id,
            'items' => [[
                'price' => 'price_1QorkEJyueeXhqQIbKDjOlGW', // Remplace par l'ID d'un prix existant
            ]],
            'expand' => ['latest_invoice.payment_intent'],
        ]);

        return $subscription;
    }

    public function cancelSubscription()
    {

    }

    public function createCustomer(
        string $name, 
        string $email, 
        string $paymentMethod
    ): \Stripe\Customer
    {
        $customer = $this->stripe->customers->create([
            'name' => $name,
            'email' => $email,
            'payment_method' => $paymentMethod, // Utilisation d'un moyen de paiement de test
            'invoice_settings' => ['default_payment_method' => $paymentMethod]
        ]);

        return $customer;
    }
}