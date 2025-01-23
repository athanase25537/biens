<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Bail;
use App\Port\In\UpdateBailImmobilierInputPort;
use App\Port\Out\BailRepositoryInterface;
use App\Core\Application\Service\HistoriqueService;

class UpdateBailUseCase
{
    private BailRepositoryInterface $bailRepository;
  	private HistoriqueService $historiqueService;

    public function __construct(BailRepositoryInterface $bailRepository, HistoriqueService $historiqueService)
    {
        $this->bailRepository = $bailRepository;
      	$this->historiqueService = $historiqueService;
    }

    public function execute(int $id, array $updatedBail, int $userId): ?array
    {

        $update = $this->bailRepository->update($id, $updatedBail);

        if ($update) {
            $this->historiqueService->enregistrerModification(
                'bail',
                $id,
                $userId,
                'mise à jour',
                json_encode($updatedBail)
            );


            return $this->bailRepository->findById($id);
        }

        return null;
    }
}