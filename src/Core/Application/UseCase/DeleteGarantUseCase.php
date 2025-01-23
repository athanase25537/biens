<?php

namespace App\Core\Application\UseCase;

use App\Core\Application\Service\HistoriqueService;
use App\Port\Out\GarantRepositoryInterface;

class DeleteGarantUseCase
{
    private GarantRepositoryInterface $garantRepository;
    private HistoriqueService $historiqueService;

    public function __construct(
        GarantRepositoryInterface $garantRepository,
        HistoriqueService $historiqueService
    ) {
        $this->garantRepository = $garantRepository;
        $this->historiqueService = $historiqueService;
    }

    public function execute(int $id, int $userId): bool
    {
        $delete = $this->garantRepository->delete($id);

        if ($delete) {
            $this->historiqueService->enregistrerModification(
                'garant_user',
                $id,
                $userId,
                'suppression',
                json_encode(['status' => 'deleted'])
            );
        }
        return $delete; 

    }
}
