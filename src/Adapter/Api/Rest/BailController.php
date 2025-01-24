<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\AddBailUseCase;
use App\Core\Application\UseCase\UpdateBailUseCase;
use App\Core\Application\UseCase\DeleteBailUseCase;
use App\Core\Application\UseCase\SendNotificationUseCase;
use App\Port\Out\BailRepositoryInterface;
use App\Core\Domain\Entity\Bail;

class BailController
{
    private $addBailUseCase;
    private $updateBailUseCase;    
  	private $deleteBailUseCase;
  	private $bailRepository;
    private $sendNotificationUseCase;


    public function __construct(
        AddBailUseCase $addBailUseCase,
        UpdateBailUseCase $updateBailUseCase,    
        DeleteBailUseCase $deleteBailUseCase,
        SendNotificationUseCase $sendNotificationUseCase
    ) {
        $this->addBailUseCase = $addBailUseCase;
        $this->updateBailUseCase = $updateBailUseCase;
        $this->deleteBailUseCase = $deleteBailUseCase;
        $this->sendNotificationUseCase = $sendNotificationUseCase;
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
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = 2; // Simulation d'un utilisateur connecté
        if (!$userId) {
            throw new \Exception("L'utilisateur n'est pas authentifié.");
        }

        // Mise à jour du bail
        $bailImmobilier = $this->updateBailUseCase->execute($idBien, $data, $userId);

        if (!$bailImmobilier) {
            throw new \Exception("Le bail avec l'ID {$idBien} n'a pas pu être trouvé ou mis à jour.");
        }

        // Envoyer une notification au propriétaire
        $notification = $this->sendNotificationUseCase->execute(
            $bailImmobilier->getProprietaireId(),
            'modification_bail',
            "Votre bail pour le bien immobilier {$bailImmobilier->getBienImmobilierId()} a été modifié par un administrateur.",
            $bailImmobilier->getProprietaireTokenPortable() // Token pour une notification mobile
        );

        // Préparer et envoyer la réponse
        header('Content-Type: application/json');
        http_response_code(200); // Code HTTP pour succès
        echo json_encode([
            'success' => true,
            'message' => 'Bien mis à jour avec succès',
            'bail_immobilier' => $bailImmobilier,
            'notification' => $notification
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

//       public function update($idBien): void
//     {
//   try {
//           $data = json_decode(file_get_contents('php://input'), true);

//           $userId = 2;
//           if (!$userId) {
//               throw new \Exception("L'utilisateur n'est pas authentifié.");
//           }

//           $bailImmobilier = $this->updateBailUseCase->execute($idBien, $data, $userId);
//             // Envoyer une notification au propriétaire du bail

//             $notification = $this->sendNotificationUseCase->execute(
//                 $bailImmobilier->getProprietaireId(),
//                 'modification_bail',
//                 "Votre bail pour le bien immobilier {$bailImmobilier->getBienImmobilierId()} a été modifié par un administrateur.",
//                 $bailImmobilier->getProprietaireTokenPortable() // Token pour une notification mobile, si nécessaire
//             );

//           // Préparer et envoyer la réponse
//           header('Content-Type: application/json');
//           http_response_code(200); // Code HTTP pour succès
//           echo json_encode([
//               'success' => true,
//               'message' => 'Bien mis à jour avec succès',
//               'bail_immobilier' => $bailImmobilier,
//               'notification' => $notification
//           ]);
//       } catch (\Exception $e) {
//           header('Content-Type: application/json');
//           http_response_code(400);
//           echo json_encode([
//               'success' => false,
//               'error' => $e->getMessage()
//           ]);
//       }
//     }
public function delete($id)
{
    try {
        $userId = 2; 
        if (!$userId) {
            throw new \Exception("L'utilisateur n'est pas authentifié.");
        }

        $isDeleted = $this->deleteBailUseCase->execute($id, $userId);

        if ($isDeleted) {

            $bail = $this->bailRepository->findById($id);

            if ($bail) {
                $notification = $this->sendNotificationUseCase->execute(
                    $bail->getProprietaireId(), 
                    'suppression_bail', 
                    "Votre bail pour le bien immobilier {$bail->getBienImmobilierId()} a été supprimé par un administrateur.",
                    $bail->getProprietaireTokenPortable() 
                );
            }
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => "Le bail avec l'ID {$id} a été supprimé."
            ]);
        } else {
            throw new \Exception("Impossible de supprimer le bail avec l'ID {$id}.");
        }
    } catch (\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

}