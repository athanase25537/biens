<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\UpdateTypeBienUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class TypeBienController
{

    private $createTypeBienUseCase;
    private $updateTypeBienUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateTypeBienUseCase $createTypeBienUseCase,
        UpdateTypeBienUseCase $updateTypeBienUseCase,
        )
    {
        $this->createTypeBienUseCase = $createTypeBienUseCase;
        $this->updateTypeBienUseCase = $updateTypeBienUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create()
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $typeBien = $this->createTypeBienUseCase->execute($data);

        // Structure de la réponse
        $response = [
            'message' => 'Type Bien enregistré avec succès',
            'type_bien' => [
                'type' => $typeBien->getType(),
                'description' => $typeBien->getDescription(),
                'created_at' => $typeBien->getCreatedAt(),
                'updated_at' => $typeBien->getUpdatedAt(),
            ],
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);                
    }

    public function update(int $typeBienId)
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $typeBien = $this->updateTypeBienUseCase->execute($typeBienId, $data);

        // Structure de la réponse
        $response = [
            'message' => 'Type Bien mis a jour avec succès',
            'type_bien' => [
                'type' => $typeBien['type'],
                'description' => $typeBien['description'],
                'created_at' => $typeBien['created_at'],
                'updated_at' => $typeBien['updated_at'],
            ],
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);                
    }

}