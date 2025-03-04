<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\UpdateEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\GetAllEtatLieuxUseCase;
use App\Core\Application\UseCase\EtatLieux\DeleteEtatLieuxUseCase;

class EtatLieuxController
{

    private $createEtatLieuxUseCase;
    private $updateEtatLieuxUseCase;
    private $getAllEtatLieuxUseCase;
    private $deleteEtatLieuxUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateEtatLieuxUseCase $createEtatLieuxUseCase,
        UpdateEtatLieuxUseCase $updateEtatLieuxUseCase,
        GetAllEtatLieuxUseCase $getAllEtatLieuxUseCase,
        DeleteEtatLieuxUseCase $deleteEtatLieuxUseCase,
        )
    {
        $this->createEtatLieuxUseCase = $createEtatLieuxUseCase;
        $this->updateEtatLieuxUseCase = $updateEtatLieuxUseCase;
        $this->getAllEtatLieuxUseCase = $getAllEtatLieuxUseCase;
        $this->deleteEtatLieuxUseCase = $deleteEtatLieuxUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create Etat des lieux by create use case
        try {
            $etatLieux = $this->createEtatLieuxUseCase->execute($data);
        } catch(\Exception $e) {
            if($e->getCode() == 1452) {
                echo "Erreur: bail id: " . $data['baux_id'] . " n'existe pas. Entrer un bail valide !";
                return;
            }
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat des lieux enregistré avec succès',
            'etat_lieux' => $etatLieux
        ];

        $this->sendResponseController::sendResponse($response, 201);        
    }

    public function update(int $etatLieuxId): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update Etat des lieux by update use case
        try {
            $etatLieux = $this->updateEtatLieuxUseCase->execute($etatLieuxId, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat des lieux mis a jour avec succès',
            'etat_lieux'=> $etatLieux
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function destroy(int $etatLieuxId, int $bauxId): void
    {
        try {
            // Delete Etat des lieux by delete use case
            $etatLieux = $this->deleteEtatLieuxUseCase->execute($etatLieuxId, $bauxId);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat des lieux supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }

    public function getAll(int $offset=0): void
    {
        try {
            // Delete Etat des lieux by delete use case
            $etatLieux = $this->getAllEtatLieuxUseCase->execute($offset);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }

        // Structure response data
        $response = [
            'message' => 'On a les 10 (ou inférieurs) états des lieux depuis ' . $offset,
            'etat_lieux' => $etatLieux
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }
}