<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\EtatLieuxItems\CreateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\UpdateEtatLieuxItemsUseCase;
use App\Core\Application\UseCase\EtatLieuxItems\DeleteEtatLieuxItemsUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class EtatLieuxItemsController
{
    private $createEtatLieuxItemsUseCase;
    private $updateEtatLieuxItemsUseCase;
    private $deleteEtatLieuxItemsUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateEtatLieuxItemsUseCase $createEtatLieuxItemsUseCase,
        UpdateEtatLieuxItemsUseCase $updateEtatLieuxItemsUseCase,
        DeleteEtatLieuxItemsUseCase $deleteEtatLieuxItemsUseCase,
        )
    {
        $this->createEtatLieuxItemsUseCase = $createEtatLieuxItemsUseCase;
        $this->updateEtatLieuxItemsUseCase = $updateEtatLieuxItemsUseCase;
        $this->deleteEtatLieuxItemsUseCase = $deleteEtatLieuxItemsUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create(): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create etat lieux items by create etat lieux items use case
        try {
            $etatLieuxItems = $this->createEtatLieuxItemsUseCase->execute($data);
        } catch(\Exception $e) {
            if($e->getCode() == 1452) {
                echo "Erreur: etat des lieux id: " . $data['etat_lieux_id'] . " n'existe pas";
                return;
            }
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat des lieux items enregistré avec succès',
            "etat_lieux_items" => [
                'id' => $etatLieuxItems->getEtatLieuxId(),
                'title' => $etatLieuxItems->getTitre(),
                'etat' => $etatLieuxItems->getEtat(),
                'plithes' => $etatLieuxItems->getPlinthes(),
                'murs' => $etatLieuxItems->getMurs(),
                'sol' => $etatLieuxItems->getSol(),
                'plafond' => $etatLieuxItems->getPlafond(),
                'portes' => $etatLieuxItems->getPortes(),
                'huissiers' => $etatLieuxItems->getHuisseries(),
                'radiateurs' => $etatLieuxItems->getRadiateurs(),
                'placards' => $etatLieuxItems->getPlacards(),
                'aerations' => $etatLieuxItems->getAerations(),
                'interrupteurs' => $etatLieuxItems->getInterrupteurs(),
                'prises_electriques' => $etatLieuxItems->getPrisesElectriques(),
                'tableau_electrique' => $etatLieuxItems->getTableauElectrique(),
                'description' => $etatLieuxItems->getDescription(),
            ]
        ];

        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function update($etatLieuxItemsId): void
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update etat lieux items by update etat lieux items use case
        try {
            $etatLieuxItems = $this->updateEtatLieuxItemsUseCase->execute($etatLieuxItemsId, $data);
        } catch(\Exception $e) {
            if($e->getCode() == 1452) {
                echo "Erreur: etat des lieux id: " . $data['etat_lieux_id'] . " n'existe pas";
                return;
            }
            echo "Erreur: " . $e->getMessage();
            return;
        }
        // Structure response data
        $response = [
            'message' => 'Etat lieux items mis a jour avec succès',
            "etat_lieux_items" => $etatLieuxItems
        ];

        $this->sendResponseController::sendResponse($response, 201);
        
    }

    public function destroy(int $etatLieuxItemsId, int $etatLieuxId): void 
    {
        try {
            $this->deleteEtatLieuxItemsUseCase->execute($etatLieuxItemsId, $etatLieuxId);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Etat lieux items supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }
}