<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Garant;
use App\Port\In\UpdateGarantImmobilierInputPort;
use App\Port\Out\GaranytRepositoryInterface;
use App\Core\Application\Service\HistoriqueService;

class UpdateGarantUseCase
{
    private GarantRepositoryInterface $garantRepository;
  	private HistoriqueService $historiqueService;

    public function __construct(GarantRepositoryInterface $garantRepository, HistoriqueService $historiqueService)
    {
        $this->garantRepository = $garantRepository;
      	$this->historiqueService = $historiqueService;
    }

    public function execute(int $id, arraGarant, int $userId): ?array
    {

        $update = $this->garantRepository->update($id, $updatedGarant);

        if ($update) {
            $this->historiqueService->enregistrerModification(
                'garant_user',
                $id,
                $userId,
                'mise à jour',
                json_encode($updatedGarant)
            );


            return $this->garantRepository->findById($id);
        }

        return null;
    }
}