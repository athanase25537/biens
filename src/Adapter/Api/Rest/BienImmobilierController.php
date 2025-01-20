<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\CreateBienImmobilierUseCase;
use App\Core\Application\UseCase\UpdateBienImmobilierUseCase;
use App\Core\Application\UseCase\DeleteBienImmobilierUseCase;

class BienImmobilierController
{

    private $createBienImmobilierUseCase;
    private $updateBienImmobilierUseCase;
    private $deleteBienImmobilierUseCase;

    public function __construct(
        CreateBienImmobilierUseCase $createBienImmobilierUseCase,
        UpdateBienImmobilierUseCase $updateBienImmobilierUseCase,    
        DeleteBienImmobilierUseCase $deleteBienImmobilierUseCase,    
    )
    {

        $this->createBienImmobilierUseCase = $createBienImmobilierUseCase;
        $this->updateBienImmobilierUseCase = $updateBienImmobilierUseCase;
        $this->deleteBienImmobilierUseCase = $deleteBienImmobilierUseCase;

    }

    public function create(): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $bienImmobilier = $this->createBienImmobilierUseCase->execute($data);

        // Structure de la réponse
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
        $this->sendResponse($response, 201);
        
    }

    public function update($idBien): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $bienImmobilier = $this->updateBienImmobilierUseCase->execute($idBien, $data);

        // Structure de la réponse
        $response = [
            'message' => 'Bien mis à jour avec succès',
            'bien_immobilier' => $bienImmobilier
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponse($response, 201);
    }

    public function destroy(int $idBienImmobilier): void
    {

        // Création du bien immobilier via le use case ou service
        $bienImmobilier = $this->deleteBienImmobilierUseCase->execute($idBienImmobilier);

        // Structure de la réponse
        $response = [
            'message' => 'Bien immobilier supprimer avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponse($response, 201);
    }

    private function sendResponse($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode(['message' => $message]);
    }

}

