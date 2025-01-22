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
        return ($update) ? $this->bailRepository->findById($id) : null;
        $this->historiqueService->enregistrerModification(
           'bail',
            $id,
            $userId,
            'modification',
            json_encode($updatedBail)
        );
    }
}