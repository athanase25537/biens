<?php

namespace App\Core\Application\UseCase\BienImmobilier;

use App\Port\In\BienImmobilier\GetBienImmobilierInputPort;
use App\Port\Out\BienImmobilierRepositoryInterface;

class GetBienImmobilierUseCase implements GetBienImmobilierInputPort
{

    private $bienImmobilierRepository;

    public function __construct(BienImmobilierRepositoryInterface $bienImmobilierRepository)
    {
        $this->bienImmobilierRepository = $bienImmobilierRepository;
    }

    /**
     * @param int $idBienImmobilier
     * @return BienImmobilier|null
     */
    public function execute(int $idBienImmobilier): ?array
    {
        return $this->bienImmobilierRepository->getBienImmobilier($idBienImmobilier);
    }
}
