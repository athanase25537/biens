<?php

namespace App\Core\Application\UseCase\Suivi;

use App\Core\Domain\Entity\Suivi;
use App\Port\In\Suivi\DeleteSuiviInputPort;
use App\Port\Out\SuiviRepositoryInterface;

class DeleteSuiviUseCase implements DeleteSuiviInputPort
{

    private $suiviRepository;

    public function __construct(SuiviRepositoryInterface $suiviRepository)
    {
        $this->suiviRepository = $suiviRepository;
    }

    public function execute(int $suiviId, int $bailId): void
    {
        $this->suiviRepository->destroy($suiviId, $bailId);
    }
}