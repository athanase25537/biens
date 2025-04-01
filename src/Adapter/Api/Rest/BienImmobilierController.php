<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\BienImmobilier\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\GetAllBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\GetBienImmobilierUseCase;
use App\Core\Application\UseCase\BienImmobilier\DeleteBienImmobilierUseCase;

class BienImmobilierController
{

    private $createBienImmobilierUseCase;
    private $updateBienImmobilierUseCase;
    private $getAllBienImmobilierUseCase;
    private $deleteBienImmobilierUseCase;
    private $getBienImmobilierUseCase;
    private $sendResponseController;

    public function __construct(
        CreateBienImmobilierUseCase $createBienImmobilierUseCase,
        UpdateBienImmobilierUseCase $updateBienImmobilierUseCase,    
        GetAllBienImmobilierUseCase $getAllBienImmobilierUseCase,    
        DeleteBienImmobilierUseCase $deleteBienImmobilierUseCase, 
        GetBienImmobilierUseCase $getBienImmobilierUseCase,   
    )
    {

        $this->createBienImmobilierUseCase = $createBienImmobilierUseCase;
        $this->updateBienImmobilierUseCase = $updateBienImmobilierUseCase;
        $this->getAllBienImmobilierUseCase = $getAllBienImmobilierUseCase;
        $this->deleteBienImmobilierUseCase = $deleteBienImmobilierUseCase;
        $this->getBienImmobilierUseCase = $getBienImmobilierUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create bien immobilier by create use case
        try {
            $bienImmobilier = $this->createBienImmobilierUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Bien immobilier enregistré avec succès',
            'bien_immobilier' => [
                'proprietaire_id' => $bienImmobilier->getProprietaireId(),
                'type_bien_id' => $bienImmobilier->getTypeBienId(),
                'etat_general' => $bienImmobilier->getEtatGeneral(),
                'classe_energetique' => $bienImmobilier->getClasseEnergetique(),
                'consommation_energetique' => $bienImmobilier->getConsommationEnergetique(),
                'emissions_ges' => $bienImmobilier->getEmissionsGes(),
                'taxe_fonciere' => $bienImmobilier->getTaxeFonciere(),
                'taxe_habitation' => $bienImmobilier->getTaxeHabitation(),
                'orientation' => $bienImmobilier->getOrientation(),
                'vue' => $bienImmobilier->getVue(),
                'type_chauffage' => $bienImmobilier->getTypeChauffage(),
                'statut_propriete' => $bienImmobilier->getStatutPropriete(),
                'description' => $bienImmobilier->getDescription(),
                'date_ajout' => $bienImmobilier->getDateAjout()->format('Y-m-d H:i:s'),
                'date_mise_a_jour' => $bienImmobilier->getDateMiseAJour()->format('Y-m-d H:i:s'),
                'adresse' => $bienImmobilier->getAdresse(),
                'immeuble' => $bienImmobilier->getImmeuble(),
                'etage' => $bienImmobilier->getEtage(),
                'quartier' => $bienImmobilier->getQuartier(),
                'ville' => $bienImmobilier->getVille(),
                'code_postal' => $bienImmobilier->getCodePostal(),
                'pays' => $bienImmobilier->getPays(),
            ],
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }

    public function update($idBien): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update bien immobilier by update use case
        try {
            $bienImmobilier = $this->updateBienImmobilierUseCase->execute($idBien, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Bien mis à jour avec succès',
            'bien_immobilier' => $bienImmobilier
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $bienImmobilierId): void
    {

        try {
            // Delete bien immobilier by delete use case
            $bienImmobilier = $this->deleteBienImmobilierUseCase->execute($bienImmobilierId);
        } catch(\Exception $e) {
            if($e->getCode() == 1451) {
                echo "Erreur: Le bien immobilier est déjà utilisé dans un bail";
                return;
            }
            echo "Erreur: " . $e->getMessage();
            return;
        }
        // Structure response data
        $response = [
            'message' => 'Bien immobilier supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function getAll($offset=0): void
    {
        try {
            // Get all bien immobilier by use case
            $bienImmobilier = $this->getAllBienImmobilierUseCase->execute(intval($offset));
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'On a les 10 (ou inférieurs) biens immobiliers depuis ' . $offset,
            'bien_immobilier' => $bienImmobilier
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function getBienImmobilierById($idBien): void
    {
        try {
            // Get all bien immobilier by use case
            $bienImmobilier = $this->getBienImmobilierUseCase->execute(intval($idBien));
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'On a le bien immobilier avec l\'id ' . $idBien,
            'bien_immobilier' => $bienImmobilier
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

}

