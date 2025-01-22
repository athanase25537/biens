<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;

class TypeBienController
{

    private $createTypeBienUseCase;

    public function __construct(CreateTypeBienUseCase $createTypeBienUseCase)
    {

        $this->createTypeBienUseCase = $createTypeBienUseCase;

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
        $this->sendResponse($response, 201);
        
    }

    private function sendResponse($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode(['message' => $message]);
    }

}