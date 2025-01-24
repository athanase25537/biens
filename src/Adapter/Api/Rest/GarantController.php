<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\AddGarantUseCase;
use App\Core\Application\UseCase\UpdateGarantUseCase;
use App\Core\Application\UseCase\DeleteGarantUseCase;
use App\Port\Out\GarantRepositoryInterface;
use App\Core\Domain\Entity\Garant;

class GarantController
{
    private $addGarantUseCase;
    private $updateGarantUseCase;    
  	private $deleteGarantUseCase;
  	private $garantRepository;


    public function __construct(
        addGarantUseCase $addGarantUseCase,
        updateGarantUseCase $updateGarantUseCase,    
		deleteGarantUseCase $deleteGarantUseCase,
    )
    {

        $this->addGarantUseCase = $addGarantUseCase;
        $this->updateGarantUseCase = $updateGarantUseCase;
      	$this->deleteGarantUseCase = $deleteGarantUseCase;

    }

    public function create()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $userId = 2;
            if (!$userId) {
                throw new \Exception("L'utilisateur n'est pas authentifié.");
            }
            $garant = new Garant();
            $garant->setUserId($data['user_id'] ?? null);
            $garant->setUserIdGarant($data['user_id_garant'] ?? null);
            

            $createdGarant = $this->addGarantUseCase->execute($garant, $userId);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
        
                    'message' => 'Garant créé avec succès'
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
      public function update($idGarant): void
    {
  try {
          $data = json_decode(file_get_contents('php://input'), true);

          $userId = 2;
          if (!$userId) {
              throw new \Exception("L'utilisateur n'est pas authentifié.");
          }
          $garantImmobilier = $this->updateGarantUseCase->execute($idGarant, $data, $userId);

          // Préparer et envoyer la réponse
          header('Content-Type: application/json');
          http_response_code(200); // Code HTTP pour succès
          echo json_encode([
              'success' => true,
              'message' => 'Garant mis à jour avec succès',
              'bail_immobilier' => $garantImmobilier
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
public function delete($id)
{
    try {
        $userId = 2; 
        if (!$userId) {
            throw new \Exception("L'utilisateur n'est pas authentifié.");
        }

        $isDeleted = $this->deleteGarantUseCase->execute($id, $userId);

        if ($isDeleted) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => "Garant avec l'ID {$id} a été supprimé."
            ]);
        } else {
            throw new \Exception("Impossible de supprimer le Garant avec l'ID {$id}.");
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