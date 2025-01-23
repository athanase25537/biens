<?php

namespace App\Core\Application\UseCase\EtatLieuxItems;

use App\Core\Domain\Entity\EtatLieuxItems;
use App\Port\In\EtatLieuxItems\DeleteEtatLieuxItemsInputPort;
use App\Port\Out\EtatLieuxItemsRepositoryInterface;

class DeleteEtatLieuxItemsUseCase implements DeleteEtatLieuxItemsInputPort
{

    private $etatLieuxItemsRepository;

    public function __construct(EtatLieuxItemsRepositoryInterface $etatLieuxItemsRepository)
    {
        $this->etatLieuxItemsRepository = $etatLieuxItemsRepository;
    }

    public function execute(int $etatLieuxItemsId, int $etatLieuxId): void
    {
        $this->etatLieuxItemsRepository->destroy($etatLieuxItemsId, $etatLieuxId);
    }
}