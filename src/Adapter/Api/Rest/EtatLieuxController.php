<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\EtatLieux\CreateEtatLieuxUseCase;

class EtatLieuxController
{

    private $createEtatLieuxUseCase;

    public function __construct(CreateEtatLieuxUseCase $createEtatLieuxUseCase)
    {
        $this->createEtatLieuxUseCase = $createEtatLieuxUseCase;
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
        $this->sendResponse($response, 201);
        
    }

    private function sendResponse($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode(['message' => $message]);
    }
}