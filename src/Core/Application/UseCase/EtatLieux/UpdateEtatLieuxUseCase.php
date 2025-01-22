<?php

namespace App\Core\Application\UseCase\EtatLieux;

use App\Core\Domain\Entity\EtatLieux;
use App\Port\In\EtatLieux\UpdateEtatLieuxInputPort;
use App\Port\Out\EtatLieuxRepositoryInterface;

class UpdateEtatLieuxUseCase implements UpdateEtatLieuxInputPort
{

    private $etatLieuxRepository;

    public function __construct(EtatLieuxRepositoryInterface $etatLieuxRepository)
    {
        $this->etatLieuxRepository = $etatLieuxRepository;
    }

    public function execute(int $etatLieuxId, array $data): ?array
    {
        $update = $this->etatLieuxRepository->update($etatLieuxId, $data);
        return ($update) ? $this->etatLieuxRepository->getEtatLieux($etatLieuxId) : null;
    }
}