<?php

namespace App\Core\Application\UseCase\Incident;

use App\Core\Domain\Entity\Incident;
use App\Port\In\Incident\DeleteIncidentInputPort;
use App\Port\Out\IncidentRepositoryInterface;

class DeleteIncidentUseCase implements DeleteIncidentInputPort
{

    private $incidentRepository;

    public function __construct(IncidentRepositoryInterface $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function execute(int $incidentId, int $bienId, int $bailId): void
    {
        $this->incidentRepository->destroy($incidentId, $bienId, $bailId);
    }
}