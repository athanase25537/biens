<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\In\DeleteBienImmobilierInputPort;
use App\Port\Out\BienImmobilierRepositoryInterface;

class DeleteBienImmobilierUseCase implements DeleteBienImmobilierInputPort
{

    private $bienImmobilierRepository;

    public function __construct(BienImmobilierRepositoryInterface $bienImmobilierRepository)
    {
        $this->bienImmobilierRepository = $bienImmobilierRepository;
    }

    public function execute(int $idBienImmobilier): void
    {
        $this->bienImmobilierRepository->destroy($idBienImmobilier);
    }
}