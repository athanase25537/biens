<?php

namespace App\Core\Application\UseCase;

use App\Core\Application\Service\HistoriqueService;
use App\Port\Out\BailRepositoryInterface;

class DeleteBailUseCase
{
    private BailRepositoryInterface $bailRepository;
    private HistoriqueService $historiqueService;

    public function __construct(
        BailRepositoryInterface $bailRepository,
        HistoriqueService $historiqueService
    ) {
        $this->bailRepository = $bailRepository;
        $this->historiqueService = $historiqueService;
    }

    public function execute(int $id, int $userId): bool
    {
        // Trouver les détails avant suppression, si nécessaire
        $bail = $this->bailRepository->findById($id);

        if (!$bail) {
            throw new \Exception("Bail avec l'ID {$id} non trouvé.");
        }

        // Suppression de l'entité
        $isDeleted = $this->bailRepository->delete($id);

        if ($isDeleted) {
            // Enregistrement de la suppression dans l'historique
            $this->historiqueService->enregistrerModification(
                'bail',          // La table cible
                $id,             // L'ID de l'entité supprimée
                $userId,         // L'utilisateur qui a effectué l'action
                'suppression',   // Type de modification
                json_encode($bail) // Détails de l'entité supprimée (si besoin)
            );
        }

        return $isDeleted;
    }
}
