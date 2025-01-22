<?php

namespace App\Core\Application\UseCase\EtatLieux;

use App\Core\Domain\Entity\EtatLieux;
use App\Port\In\EtatLieux\DeleteEtatLieuxInputPort;
use App\Port\Out\EtatLieuxRepositoryInterface;

class DeleteEtatLieuxUseCase implements DeleteEtatLieuxInputPort
{

    private $etatLieuxRepository;

    public function __construct(EtatLieuxRepositoryInterface $etatLieuxRepository)
    {
        $this->etatLieuxRepository = $etatLieuxRepository;
    }

    public function execute(int $etatLieuxId, int $bauxId): void
    {
        $this->etatLieuxRepository->destroy($etatLieuxId, $bauxId);
    }
}