<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\EtatLieuxItems;
use App\Port\In\DeleteEtatLieuxItemsInputPort;
use App\Port\Out\EtatLieuxItemsRepositoryInterface;

class DeleteEtatLieuxItemsUseCase implements DeleteEtatLieuxItemsInputPort
{

    private $etatLieuxItemsRepository;

    public function __construct(EtatLieuxItemsRepositoryInterface $etatLieuxItemsRepository)
    {
        $this->etatLieuxItemsRepository = $etatLieuxItemsRepository;
    }

    public function execute(int $etatLieuxItemsId): void
    {
        $this->etatLieuxItemsRepository->destroy($etatLieuxItemsId);
    }
}