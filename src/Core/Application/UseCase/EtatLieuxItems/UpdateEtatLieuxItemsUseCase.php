<?php

namespace App\Core\Application\UseCase\EtatLieuxItems;

use App\Core\Domain\Entity\EtatLieuxItems;
use App\Port\In\EtatLieuxItems\UpdateEtatLieuxItemsInputPort;
use App\Port\Out\EtatLieuxItemsRepositoryInterface;

class UpdateEtatLieuxItemsUseCase implements UpdateEtatLieuxItemsInputPort
{

    private $etatLieuxItemsRepository;

    public function __construct(EtatLieuxItemsRepositoryInterface $etatLieuxItemsRepository)
    {
        $this->etatLieuxItemsRepository = $etatLieuxItemsRepository;
    }

    public function execute(int $etatLieuxItemsId, array $data): ?array
    {
        $update = $this->etatLieuxItemsRepository->update($etatLieuxItemsId, $data);
        return ($update) ? $this->etatLieuxItemsRepository->getEtatLieuxItems($etatLieuxItemsId) : null;
    }
}