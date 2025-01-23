<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\AddBailUseCase;
use App\Core\Application\UseCase\UpdateBailUseCase;
use App\Core\Domain\Entity\Bail;

class BailController
{
    private $addBailUseCase;
    private $updateBailUseCase;

    public function __construct(
        AddBailUseCase $addBailUseCase,
        updateBailUseCase $updateBailUseCase,    

    )
    {

        $this->addBailUseCase = $addBailUseCase;
        $this->updateBailUseCase = $updateBailUseCase;

    }

    public function create()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $userId = 2;
            if (!$userId) {
                throw new \Exception("L'utilisateur n'est pas authentifié.");
            }
            // Créer un nouvel objet Bail avec les données reçues
            $bail = new Bail();
            $bail->setGarantId($data['garant_id'] ?? null);
            $bail->setBienImmobilierId($data['bien_immobilier_id'] ?? null);
            $bail->setMontantLoyer($data['montant_loyer'] ?? null);
            $bail->setMontantCharge($data['montant_charge'] ?? null);
            $bail->setMontantCaution($data['montant_caution'] ?? null);
            $bail->setEcheancePaiement($data['echeance_paiement'] ?? null);
            $bail->setDateDebut(new \DateTime($data['date_debut'] ?? 'now'));
            $bail->setDateFin(new \DateTime($data['date_fin'] ?? 'now'));
            $bail->setDureePreavis($data['duree_preavis'] ?? null);
            $bail->setStatut($data['statut'] ?? null);
            $bail->setEngagementAttestationAssurance($data['engagement_attestation_assurance'] ?? null);
            $bail->setModePaiement($data['mode_paiement'] ?? null);
            $bail->setConditionsSpeciales($data['conditions_speciales'] ?? null);
            $bail->setReferencesLegales($data['references_legales'] ?? null);
            $bail->setIndexationAnnuelle($data['indexation_annuelle'] ?? null);
            $bail->setIndiceReference($data['indice_reference'] ?? null);
            $bail->setCautionRemboursee($data['caution_remboursee'] ?? null);
            
            if (isset($data['date_remboursement_caution'])) {
                $bail->setDateRemboursementCaution(new \DateTime($data['date_remboursement_caution']));
            }

            // Exécuter le use case
            $createdBail = $this->addBailUseCase->execute($bail, $userId);

            // Renvoyer la réponse
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
                    'id' => $createdBail->getId(),
                    'message' => 'Bail créé avec succès'
                ]
            ]);

        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    public function update($idBien): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            throw new \Exception("L'utilisateur n'est pas authentifié.");
        }
        $bailImmobilier = $this->updateBailUseCase->execute($idBien, $data, $userId);

        $response = [
            'message' => 'Bien mis à jour enregistré avec succès',
            'bail_immobilier' => $bailImmobilier
        ];

        $this->sendResponse($response, 201);
    }
    public function delete($id, $userId)
    {
        try {
            $isDeleted = $this->deleteBailUseCase->execute($id, $userId);

            if ($isDeleted) {
                return [
                    'success' => true,
                    'message' => "Le bail avec l'ID {$id} a été supprimé."
                ];
            }

            return [
                'success' => false,
                'message' => "Impossible de supprimer le bail avec l'ID {$id}."
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

}