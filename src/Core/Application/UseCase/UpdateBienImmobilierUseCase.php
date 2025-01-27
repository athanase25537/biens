<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\In\UpdateBienImmobilierInputPort;
use App\Port\Out\BienImmobilierRepositoryInterface;

class UpdateBienImmobilierUseCase implements UpdateBienImmobilierInputPort
{

    private $bienImmobilierRepository;

    public function __construct(BienImmobilierRepositoryInterface $bienImmobilierRepository)
    {
        $this->bienImmobilierRepository = $bienImmobilierRepository;
    }

    public function execute(int $idBienImmobilier, array $data): ?array
    {
        $update = $this->bienImmobilierRepository->update($idBienImmobilier, $data);
        return ($update) ? $this->bienImmobilierRepository->getBienImmobilier($idBienImmobilier) : null;
    }
}