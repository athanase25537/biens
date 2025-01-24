<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\Suivi\CreateSuiviUseCase;
// use App\Core\Application\UseCase\Suivi\UpdateSuiviUseCase;
// use App\Core\Application\UseCase\Suivi\DeleteSuiviUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class SuiviController
{
    private $createSuiviUseCase;
    // private $updateSuiviUseCase;
    // private $deleteSuiviUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateSuiviUseCase $createSuiviUseCase,
        // UpdateSuiviUseCase $updateSuiviUseCase,
        // DeleteSuiviUseCase $deleteSuiviUseCase
    
    )
    {
        $this->createSuiviUseCase = $createSuiviUseCase;
        // $this->updateSuiviUseCase = $updateSuiviUseCase;
        // $this->deleteSuiviUseCase = $deleteSuiviUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $suivi = $this->createSuiviUseCase->execute($data);

        // Structure de la réponse
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

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
        
    }

    /*
    public function update(int $quittanceLoyerId): void 
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du etat lieux items via le use case ou service
        $etatLieux = $this->UdateQuittanceLoyerUseCase->execute($incidentId, $data);

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
    */
}