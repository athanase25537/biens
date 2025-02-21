<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\UserAbonnement\CreateUserAbonnementUseCase;
use App\Core\Application\UseCase\UserAbonnement\UpdateUserABonnementUseCase;
use App\Core\Application\UseCase\UserAbonnement\DeleteUserABonnementUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class UserAbonnementController
{

    private $createUserAbonnementUseCase;
    private $updateUserAbonnementUseCase;
    private $deleteUserAbonnementUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateUserAbonnementUseCase $createUserAbonnementUseCase,
        UpdateUserAbonnementUseCase $updateUserAbonnementUseCase,
        // DeleteUserAbonnementUseCase $deleteUserAbonnementUseCase,
        )
    {
        $this->createUserAbonnementUseCase = $createUserAbonnementUseCase;
        $this->updateUserAbonnementUseCase = $updateUserAbonnementUseCase;
        // $this->deleteUserAbonnementUseCase = $deleteUserAbonnementUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create()
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create user abonnement by user abonnement use case
        try {
            $userAbonnement = $this->createUserAbonnementUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'User Abonnement enregistré avec succès',
            'user_abonnement' => [
                'user_id' => $userAbonnement->getUserId(),
                'abonnement_id' => $userAbonnement->getAbonnementId(),
                'payments_id' => $userAbonnement->getPaymentsId(),
                'type_formule' => $userAbonnement->getTypeFormule(),
                'prix_ht' => $userAbonnement->getPrixHt(),
                'tva_rate' => $userAbonnement->getTvaRate(),
                'montant_tva' => $userAbonnement->getMontantTva(),
                'montant_ttc' => $userAbonnement->getMontantTtc(),
                'date_acquisition' => $userAbonnement->getDateAcquisition()->format('Y-m-d'),
                'date_expiration' => $userAbonnement->getDateExpiration()->format('Y-m-d'),
                'statut' => $userAbonnement->getStatut(),
                'suivi' => $userAbonnement->getSuivi(),
                'created_at' => $userAbonnement->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $userAbonnement->getUpdatedAt()->format('Y-m-d H:i:s'),
            ],
        ];
        
        $this->sendResponseController::sendResponse($response, 201);                
    }

    public function update($userAbonnementId): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update user abonnement by user abonnement use case
        try {
            $userAbonnement = $this->updateUserAbonnementUseCase->execute($userAbonnementId, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat lieux mis a jour avec succès',
            'etat_lieux'=> $userAbonnement
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }
}