<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\UpdateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\DeleteEtatLieuxItemsUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class EtatLieuxItemsController
{
    private $createEtatLieuxItemsUseCase;
    private $updateEtatLieuxItemsUseCase;
    private $deleteEtatLieuxItemsUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateEtatLieuxItemsUseCase $createEtatLieuxItemsUseCase,
        UpdateEtatLieuxItemsUseCase $updateEtatLieuxItemsUseCase,
        DeleteEtatLieuxItemsUseCase $deleteEtatLieuxItemsUseCase,
        )
    {
        $this->createEtatLieuxItemsUseCase = $createEtatLieuxItemsUseCase;
        $this->updateEtatLieuxItemsUseCase = $updateEtatLieuxItemsUseCase;
        $this->deleteEtatLieuxItemsUseCase = $deleteEtatLieuxItemsUseCase;
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

    public function update($etatLieuxItemsId): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du etat lieux items via le use case ou service
        $etatLieuxItems = $this->updateEtatLieuxItemsUseCase->execute($etatLieuxItemsId, $data);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux items mis a jour avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function destroy(int $etatLieuxItemsId, int $etatLieuxId): void 
    {
        $this->deleteEtatLieuxItemsUseCase->execute($etatLieuxItemsId, $etatLieuxId);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux items supprimer avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }
}