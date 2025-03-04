<?php

namespace App\Core\Application\UseCase\EtatLieux;

use App\Core\Domain\Entity\EtatLieux;
use App\Port\In\EtatLieux\GetAllEtatLieuxInputPort;
use App\Port\Out\EtatLieuxRepositoryInterface;

class GetAllEtatLieuxUseCase implements GetAllEtatLieuxInputPort
{

    private $etatLieuxRepository;

    public function __construct(EtatLieuxRepositoryInterface $etatLieuxRepository)
    {
        $this->etatLieuxRepository = $etatLieuxRepository;
    }

    public function execute(int $offset): ?array
    {
        return $this->etatLieuxRepository->getAllEtatLieux($offset);
    }
}