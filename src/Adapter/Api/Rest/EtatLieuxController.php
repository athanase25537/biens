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
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create etat lieux by create use case
        try {
            $etatLieux = $this->createEtatLieuxUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat lieux enregistré avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);        
    }

    public function update(int $etatLieuxId): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update etat lieux by update use case
        try {
            $etatLieux = $this->updateEtatLieuxUseCase->execute($etatLieuxId, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat lieux mis a jour avec succès',
            'etat_lieux'=> $etatLieux
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $etatLieuxId, int $bauxId): void
    {
        try {
            // Delete etat lieux by delete use case
            $etatLieux = $this->deleteEtatLieuxUseCase->execute($etatLieuxId, $bauxId);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }

        // Structure response data
        $response = [
            'message' => 'Etat lieux supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }
}