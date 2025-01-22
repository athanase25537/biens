<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\UpdateEtatLieuxUseCase;

class EtatLieuxController
{

    private $createEtatLieuxUseCase;
    private $updateEtatLieuxUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateEtatLieuxUseCase $createEtatLieuxUseCase,
        UpdateEtatLieuxUseCase $updateEtatLieuxUseCase,
        )
    {
        $this->createEtatLieuxUseCase = $createEtatLieuxUseCase;
        $this->updateEtatLieuxUseCase = $updateEtatLieuxUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du bien immobilier via le use case ou service
        $etatLieux = $this->createEtatLieuxUseCase->execute($data);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux enregistré avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);        
    }

    public function update(int $etatLieuxId): void
    {
        // Récupération des données de la requête
        $data = json_decode(file_get_contents('php://input'), true);

        // Création du etat lieux items via le use case ou service
        $etatLieux = $this->updateEtatLieuxUseCase->execute($etatLieuxId, $data);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux mis a jour avec succès',
            'etat_lieux'=> $etatLieux
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }
}