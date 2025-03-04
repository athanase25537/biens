<?php

namespace App\Core\Application\UseCase\BienImmobilier;

use App\Core\Domain\Entity\BienImmobilier;
use App\Port\In\BienImmobilier\GetAllBienImmobilierInputPort;
use App\Port\Out\BienImmobilierRepositoryInterface;

class GetAllBienImmobilierUseCase implements GetAllBienImmobilierInputPort
{

    private $bienImmobilierRepository;

    public function __construct(BienImmobilierRepositoryInterface $bienImmobilierRepository)
    {
        $this->bienImmobilierRepository = $bienImmobilierRepository;
    }

    public function execute(int $offset): ?array
    {
        return $this->bienImmobilierRepository->getAllBienImmobilier($offset);
    }
}