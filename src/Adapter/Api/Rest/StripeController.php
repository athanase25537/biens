<?php

namespace App\Controller;

use App\Adapter\Persistence\Stripe\SubscriptionStripe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    private SubscriptionStripe $subscriptionStripe;

    public function __construct(SubscriptionStripe $subscriptionStripe)
    {
        $this->subscriptionStripe = $subscriptionStripe;
    }

    public function createCustomer(Request $request): Response
    {
        $email = $request->get('email');
        $name = $request->get('name');

        try {
            $customer = $this->subscriptionStripe->createCustomer($email, $name);
            return $this->json(['customerId' => $customer->id]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function addPaymentMethod(Request $request): Response
    {
        $paymentMethodId = $request->get('paymentMethodId');
        $customerId = $request->get('customerId');

        try {
            $this->subscriptionStripe->addPaymentMethod($paymentMethodId, $customerId);
            return $this->json(['status' => 'Payment method added successfully']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createSubscription(Request $request): Response
    {
        $customerId = $request->get('customerId');
        $priceId = $request->get('priceId');

        try {
            $subscription = $this->subscriptionStripe->createSubscription($customerId, $priceId);
            return $this->json(['subscriptionId' => $subscription->id]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function cancelSubscription(Request $request): Response
    {
        $subscriptionId = $request->get('subscriptionId');

        try {
            $subscription = $this->subscriptionStripe->cancelSubscription($subscriptionId);
            return $this->json(['status' => 'Subscription cancelled']);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function handleWebhook(Request $request): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->headers->get('Stripe-Signature');

        try {
            $this->subscriptionStripe->handleWebhook($payload, $sigHeader);
            return new Response('Webhook handled successfully');
        } catch (\Exception $e) {
            return new Response('Webhook handling failed: ' . $e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}