<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\QuittanceLoyer\CreateQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\UpdateQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\DeleteQuittanceLoyerUseCase;
use App\Core\Application\UseCase\QuittanceLoyer\SelectLastQuittanceByBailIdUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class QuittanceLoyerController
{
    private $createQuittanceLoyerUseCase;
    private $updateQuittanceLoyerUseCase;
    private $deleteQuittanceLoyerUseCase;
    private $selectLastQuittanceByBailIdUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateQuittanceLoyerUseCase $createQuittanceLoyerUseCase,
        UpdateQuittanceLoyerUseCase $updateQuittanceLoyerUseCase,
        DeleteQuittanceLoyerUseCase $deleteQuittanceLoyerUseCase,
        SelectLastQuittanceByBailIdUseCase $selectLastQuittanceByBailIdUseCase
    
    )
    {
        $this->createQuittanceLoyerUseCase = $createQuittanceLoyerUseCase;
        $this->updateQuittanceLoyerUseCase = $updateQuittanceLoyerUseCase;
        $this->deleteQuittanceLoyerUseCase = $deleteQuittanceLoyerUseCase;
        $this->selectLastQuittanceByBailIdUseCase = $selectLastQuittanceByBailIdUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create quittance loyer by create quittance loyer use case
        try {
            $quittanceLoyer = $this->createQuittanceLoyerUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
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

        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function update(int $quittanceLoyerId): void 
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update quittance loyer by update quittance loyer use case
        try {
            $quittanceLoyer = $this->updateQuittanceLoyerUseCase->execute($quittanceLoyerId, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Quittance mis a jour avec succès',
            'etat_lieux'=> $quittanceLoyer
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $quittanceLoyerId, int $bailId): void 
    {
        $this->deleteQuittanceLoyer->execute($quittanceLoyerId, $bailId);

        // Structure response data
        $response = [
            'message' => 'Quittance loyer supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);   
    }

    public function selectLastQuittanceByBailId(int $bailId): void 
    {
        try{
            $quittanceLoyer = $this->selectLastQuittanceByBailIdUseCase->execute($bailId);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }
    
        // Structure de la réponse JSON
        $response = [
            'message' => 'Selection dernier quittance réussi avec succès',
            'quittance_loyer' => $quittanceLoyer
        ];
    
        // Préparation des données pour le PDF
        $dateEmission = (new \DateTime($quittanceLoyer['date_emission']))->format('m/Y');
        $filename = (new \DateTime($quittanceLoyer['date_emission']))->format('m_Y');
        $montant = $quittanceLoyer['montant'];
        $montantCharge = $quittanceLoyer['montant_charge'];
        $montantImpayer = $quittanceLoyer['montant_impayer'];
        $montantLoyerPayer = $montant;
        $montantChargePayer = 0.00;
        $reste = $montant - $montantChargePayer;
        $resteAPayerMoisPrecedent = 122.14;
        $resteAPayer = $resteAPayerMoisPrecedent + $reste;
        $createdAt = (new \DateTime($quittanceLoyer['created_at']))->format('d/m/Y');
        $datePaiement = $createdAt;

        require_once('tcpdf.php');
    }
    
}