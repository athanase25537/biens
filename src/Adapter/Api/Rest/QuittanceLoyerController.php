<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\QuittanceLoyer\CreateQuittanceLoyerUseCase;
// use App\Core\Application\UseCase\QuittanceLoyer\UpdateQuittanceLoyerUseCase;
// use App\Core\Application\UseCase\QuittanceLoyer\DeleteQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\SelectLastQuittanceByBailIdUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class QuittanceLoyerController
{
    private $createQuittanceLoyerUseCase;
    // private $updateQuittanceLoyerUseCase;
    // private $deleteQuittanceLoyerUseCase;
    private $selectLastQuittanceByBailIdUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateQuittanceLoyerUseCase $createQuittanceLoyerUseCase,
        // UpdateIncidentUseCase $updateQuittanceLoyerUseCase,
        // DeleteIncidentUseCase $deleteQuittanceLoyerUseCase
        SelectLastQuittanceByBailIdUseCase $selectLastQuittanceByBailIdUseCase
    
    )
    {
        $this->createQuittanceLoyerUseCase = $createQuittanceLoyerUseCase;
        // $this->updateQuittanceLoyerUseCase = $updateQuittanceLoyerUseCase;
        // $this->deleteQuittanceLoyerUseCase = $deleteQuittanceLoyerUseCase;
        $this->selectLastQuittanceByBailIdUseCase = $selectLastQuittanceByBailIdUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $quittanceLoyer = $this->createQuittanceLoyerUseCase->execute($data);

        // Structure de la réponse
        $response = [
            'message' => 'Quittance Loyer enregistré avec succès',
            'quittance_loyer' => [
                'bail_id' => $quittanceLoyer->getBailId(),
                'montant' => $quittanceLoyer->getMontant(),
                'date_emission' => $quittanceLoyer->getDateEmission(),
                'statut' => $quittanceLoyer->getStatut(),
                'description' => $quittanceLoyer->getDescription(),
                'moyen_paiement' => $quittanceLoyer->getMoyenPaiement(),
                'montant_charge' => $quittanceLoyer->getMontantCharge(),
                'montant_impayer' => $quittanceLoyer->getMontantImpayer(),
                'created_at' => $quittanceLoyer->getCreatedAt(),
                'updated_at' => $quittanceLoyer->getUpdatedAt(),
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

    public function selectLastQuittanceByBailId(int $bailId): void 
    {
        $quittanceLoyer = $this->selectLastQuittanceByBailIdUseCase->execute($bailId);

        // Structure de la réponse
        $response = [
            'message' => 'Selection dernir quittance reussi avec succès',
            'quittance_loyer' => $quittanceLoyer
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }
}