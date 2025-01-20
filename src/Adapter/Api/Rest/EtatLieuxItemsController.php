<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\CreateEtatLieuxItemsUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class EtatLieuxItemsController
{
    private $createEtatLieuxItemsUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(CreateEtatLieuxItemsUseCase $createEtatLieuxItemsUseCase)
    {
        $this->createEtatLieuxItemsUseCase = $createEtatLieuxItemsUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $etatLieuxItems = $this->createEtatLieuxItemsUseCase->execute($data);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux items enregistré avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
        
    }
}