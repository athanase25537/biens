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
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $userAbonnement = $this->createUserAbonnementUseCase->execute($data);

        // Structure de la réponse
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
        

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);                
    }

    public function update($userAbonnementId): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du etat lieux items via le use case ou service
        $userAbonnement = $this->updateUserAbonnementUseCase->execute($userAbonnementId, $data);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux mis a jour avec succès',
            'etat_lieux'=> $userAbonnement
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }
}