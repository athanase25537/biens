<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\Incident\CreateIncidentUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class IncidentController
{
    private $createIncidentUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(CreateIncidentUseCase $createIncidentUseCase)
    {
        $this->createIncidentUseCase = $createIncidentUseCase;
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
}