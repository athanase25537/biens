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
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create incident by create incident use case
        try {
            $incident = $this->createIncidentUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure responce data
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

        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function update(int $incidentId): void 
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update incident by udate incident use case
        try {
            $incident = $this->updateIncidentUseCase->execute($incidentId, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Incident mis a jour avec succès',
            'etat_lieux'=> $incident
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $incidentId, int $bienId, int $bailId): void 
    {
        try {
            // Delete incident by delete incident use case
            $this->deleteIncidentUseCase->execute($incidentId, $bienId, $bailId);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Incident supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);   
    }
}