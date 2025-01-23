<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\Incident\CreateIncidentUseCase;
use App\Core\Application\UseCase\Incident\UpdateIncidentUseCase;
use App\Core\Application\UseCase\Incident\DeleteIncidentUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class IncidentController
{
    private $createIncidentUseCase;
    private $updateIncidentUseCase;
    private $deleteIncidentUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateIncidentUseCase $createIncidentUseCase,
        UpdateIncidentUseCase $updateIncidentUseCase,
        DeleteIncidentUseCase $deleteIncidentUseCase
    
    )
    {
        $this->createIncidentUseCase = $createIncidentUseCase;
        $this->updateIncidentUseCase = $updateIncidentUseCase;
        $this->deleteIncidentUseCase = $deleteIncidentUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $incident = $this->createIncidentUseCase->execute($data);

        // Structure de la réponse
        $response = [
            'message' => 'Incident enregistré avec succès',
            'incident' => [
                'bien_id' => $incident->getBienId(),
                'bail_id' => $incident->getBailId(),
                'description' => $incident->getDescription(),
                'statut' => $incident->getStatut(),
                'date_signalement' => $incident->getDateSignalement(),
                'date_resolution' => $incident->getDateResolution(),
            ]
        ];        

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function update(int $incidentId): void 
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du etat lieux items via le use case ou service
        $etatLieux = $this->updateIncidentUseCase->execute($incidentId, $data);

        // Structure de la réponse
        $response = [
            'message' => 'Incident mis a jour avec succès',
            'etat_lieux'=> $etatLieux
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $incidentId, int $bienId, int $bailId): void 
    {
        $this->deleteIncidentUseCase->execute($incidentId, $bienId, $bailId);

        // Structure de la réponse
        $response = [
            'message' => 'Incident supprimer avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);   
    }
}