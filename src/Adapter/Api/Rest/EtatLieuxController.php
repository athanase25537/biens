<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\UpdateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\DeleteEtatLieuxUseCase;

class EtatLieuxController
{

    private $createEtatLieuxUseCase;
    private $updateEtatLieuxUseCase;
    private $deleteEtatLieuxUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateEtatLieuxUseCase $createEtatLieuxUseCase,
        UpdateEtatLieuxUseCase $updateEtatLieuxUseCase,
        DeleteEtatLieuxUseCase $deleteEtatLieuxUseCase,
        )
    {
        $this->createEtatLieuxUseCase = $createEtatLieuxUseCase;
        $this->updateEtatLieuxUseCase = $updateEtatLieuxUseCase;
        $this->deleteEtatLieuxUseCase = $deleteEtatLieuxUseCase;
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

    public function destroy(int $etatLieuxId, int $bauxId): void
    {
        // Création du etat lieux items via le use case ou service
        $etatLieux = $this->deleteEtatLieuxUseCase->execute($etatLieuxId, $bauxId);

        // Structure de la réponse
        $response = [
            'message' => 'Etat lieux supprimer avec succès',
        ];

        // Envoi de la réponse avec un statut HTTP 201 (Créé)
        $this->sendResponseController::sendResponse($response, 201);
    }
}