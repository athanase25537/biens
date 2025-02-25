<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\Suivi\CreateSuiviUseCase;
use App\Core\Application\UseCase\Suivi\UpdateSuiviUseCase;
// use App\Core\Application\UseCase\Suivi\DeleteSuiviUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class SuiviController
{
    private $createSuiviUseCase;
    private $updateSuiviUseCase;
    // private $deleteSuiviUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateSuiviUseCase $createSuiviUseCase,
        UpdateSuiviUseCase $updateSuiviUseCase,
        // DeleteSuiviUseCase $deleteSuiviUseCase
    
    )
    {
        $this->createSuiviUseCase = $createSuiviUseCase;
        $this->updateSuiviUseCase = $updateSuiviUseCase;
        // $this->deleteSuiviUseCase = $deleteSuiviUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create suivi by create suivi use case
        try {
            $suivi = $this->createSuiviUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Suivi paiement enregistré avec succès',
            'suivi' => [
                'quittance_id' => $suivi->getQuittanceId(),
                'montant' => $suivi->getMontant(),
                'date_paiement' => $suivi->getDatePaiement()->format('Y-m-d H:i:s'),
                'statut' => $suivi->getStatut(),
                'created_at' => $suivi->getCreatedAt()->format('Y-m-d H:i:s'),
                'updated_at' => $suivi->getUpdatedAt()->format('Y-m-d H:i:s'),
            ]
        ];        

        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function update(int $quittanceLoyerId): void 
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update suivi
        $suivi = $this->UdateQuittanceLoyerUseCase->execute($suiviId, $data);

        // Structure response data
        $response = [
            'message' => 'Suivi mis a jour avec succès',
            'suivi'=> $suivi
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $suiviId, int $bailId): void 
    {
        $this->deleteIncidentUseCase->execute($suiviId, $bailId);

        // Structure de la réponse
        $response = [
            'message' => 'Suivi supprimer avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);   
    }
}