<?php
namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Garant;
use App\Port\Out\GarantRepositoryInterface;
use App\Core\Application\Service\HistoriqueService;

class AddGarantUseCase
{
    private GarantRepositoryInterface $garantRepository;
  	private HistoriqueService $historiqueService;

    public function __construct(GarantRepositoryInterface $garantRepository, HistoriqueService $historiqueService)
    {
        $this->garantRepository = $garantRepository;
      	$this->historiqueService = $historiqueService;
    }

      public function execute(Bail $garant, int $userId): Bail
    {
        $savedGarant = $this->garantRepository->save($garant);

        $this->historiqueService->enregistrerModification(
            'bail',
            $savedBail->getId(),
            $userId,     
            'création',
            json_encode([
                'user_id' => $savedGarant->getUserId(),
                'user_id_garant' => $savedGarant->getUserIdGarant(),                
            ])
        );

        return $savedGarant;
    }
}
