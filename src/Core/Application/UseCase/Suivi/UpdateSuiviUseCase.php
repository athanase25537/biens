<?php

namespace App\Core\Application\UseCase\Suivi;

use App\Core\Domain\Entity\Suivi;
use App\Port\In\Suivi\UpdateSuiviInputPort;
use App\Port\Out\SuiviRepositoryInterface;

class UpdateSuiviUseCase implements UpdateSuiviInputPort
{

    private $suiviRepository;

    public function __construct(SuiviRepositoryInterface $suiviRepository)
    {
        $this->suiviRepository = $suiviRepository;
    }

    public function execute(int $suiviId, array $data): ?array
    {
        $update = $this->suiviRepository->update($suiviId, $data);
        return ($update) ? $this->suiviRepository->getSuivi($suiviId) : null;
    }
}
