<?php
namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Bail;
use App\Port\Out\BailRepositoryInterface;
use App\Core\Application\Service\HistoriqueService;

class AddBailUseCase
{
    private BailRepositoryInterface $bailRepository;
  	private HistoriqueService $historiqueService;

    public function __construct(BailRepositoryInterface $bailRepository, HistoriqueService $historiqueService)
    {
        $this->bailRepository = $bailRepository;
      	$this->historiqueService = $historiqueService;
    }

    /*public function execute(Bail $bail): Bail
    {
        return $this->bailRepository->save($bail);
    }*/
      public function execute(Bail $bail, int $userId): Bail
    {
        $savedBail = $this->bailRepository->save($bail);

        $this->historiqueService->enregistrerModification(
            'bail',
            $savedBail->getId(),
            $userId,     
            'création',
            json_encode($savedBail)
        );

        return $savedBail;
    }
}
