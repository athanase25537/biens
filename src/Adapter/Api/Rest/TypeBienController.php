<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\TypeBien\CreateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\UpdateTypeBienUseCase;
use App\Core\Application\UseCase\TypeBien\DeleteTypeBienUseCase;
use App\Adapter\Api\Rest\SendResponseController;

class TypeBienController
{

    private $createTypeBienUseCase;
    private $updateTypeBienUseCase;
    private $deleteTypeBienUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        CreateTypeBienUseCase $createTypeBienUseCase,
        UpdateTypeBienUseCase $updateTypeBienUseCase,
        DeleteTypeBienUseCase $deleteTypeBienUseCase,
        )
    {
        $this->createTypeBienUseCase = $createTypeBienUseCase;
        $this->updateTypeBienUseCase = $updateTypeBienUseCase;
        $this->deleteTypeBienUseCase = $deleteTypeBienUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function create()
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Create type bien by type bien use case
        try {
            $typeBien = $this->createTypeBienUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Type Bien enregistré avec succès',
            'type_bien' => [
                'type' => $typeBien->getType(),
                'description' => $typeBien->getDescription(),
                'created_at' => $typeBien->getCreatedAt(),
                'updated_at' => $typeBien->getUpdatedAt(),
            ],
        ];

        $this->sendResponseController::sendResponse($response, 201);                
    }

    public function update(int $typeBienId)
    {
        // Get request data
        $data = json_decode(file_get_contents('php://input'), true);

        // Update type bien by type bien use case
        try {
            $typeBien = $this->updateTypeBienUseCase->execute($typeBienId, $data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Type Bien mis a jour avec succès',
            'type_bien' => [
                'type' => $typeBien['type'],
                'description' => $typeBien['description'],
                'created_at' => $typeBien['created_at'],
                'updated_at' => $typeBien['updated_at'],
            ],
        ];

        $this->sendResponseController::sendResponse($response, 201);                
    }

    public function destroy(int $typeBienId): void 
    {
        try {
            // delete type bien by type bien use case
            $this->deleteTypeBienUseCase->execute($typeBienId);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        // Structure response data
        $response = [
            'message' => 'Type Bien supprimer avec succès',
        ];

        $this->sendResponseController::sendResponse($response, 201);
    }
}