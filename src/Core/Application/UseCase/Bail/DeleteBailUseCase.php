<?php

namespace App\Core\Application\UseCase\Bail;

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
    {/*
		$bail = $this->bailRepository->findById($id);

        if (!$bail) {
            throw new \Exception("Bail avec l'ID {$id} non trouvé.");
        }*/
        $delete = $this->bailRepository->delete($id);

        if ($delete) {
            $this->historiqueService->enregistrerModification(
                'bail',
                $id,
                $userId,
                'suppression',
                json_encode(['status' => 'deleted'])
            );
        }
        return $delete; 

    }
}
