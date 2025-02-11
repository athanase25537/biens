<?php

namespace App\Core\Application\UseCase\UserAbonnement;

use App\Core\Domain\Entity\UserAbonnement;
use App\Port\In\UserAbonnement\CreateUserAbonnementInputPort;
use App\Port\Out\UserAbonnementRepositoryInterface;

class CreateUserAbonnementUseCase implements CreateUserAbonnementInputPort
{

    private $userAbonnementRepository;

    public function __construct(UserAbonnementRepositoryInterface $userAbonnementRepository)
    {
        $this->userAbonnementRepository = $userAbonnementRepository;
    }

    public function execute(array $data): UserAbonnement
    {
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

            $paymentId = $paymentMethods->id; 

            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentId);
            if ($paymentMethod) {
                $paymentMethod->attach(['customer' => $customer->id]);
            } else {
                throw new Exception("Le moyen de paiement est introuvable.");
            }

            \Stripe\Customer::update($customer->id, [
                'invoice_settings' => ['default_payment_method' => $paymentId]
            ]);

            $price = 'price_1QorkEJyueeXhqQIbKDjOlGW';
            $subscription = $stripeService->createSubscription($customer->id, $price);
            
            $created_at = date('Y-m-d H:i:s', $subscription->created);
            $period_end = date('Y-m-d H:i:s', $subscription->current_period_end);
            $period_start = date('Y-m-d H:i:s', $subscription->current_period_start);
            $items = $subscription->items;
            $plan = $items->data[0]->plan;
            $prix_ht = $plan->amount;
            $type_formule = $plan->interval == 'month' ? 1 : 2;
            $status = 1;
            if($subscription->status == 'expire') $status = 2;
            else if($subscription->status == 'cancel') $status = 3;
            exit();
        } catch (\Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }

        $userAbonnement = new UserAbonnement(
            (int)$data['user_id'],
            $subscription->id,
            $paymentId,
            $type_formule,
            (float)$prix_ht,
            (float)$data['tva_rate'],
            (float)$data['montant_tva'],
            (float)$data['montant_ttc'],
            $period_start,
            $period_end,
            $status,
            $data['suivi'] ?? null,
            $created_at,
            new \DateTime($data['updated_at'])
        );

        $userAbonnement = $this->userAbonnementRepository->save($userAbonnement);
        return $userAbonnement;
    }
}