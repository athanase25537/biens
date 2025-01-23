<?php

namespace App\Core\Application\UseCase\Incident;

use App\Core\Domain\Entity\Incident;
use App\Port\In\Incident\UpdateIncidentInputPort;
use App\Port\Out\IncidentRepositoryInterface;

class UpdateIncidentUseCase implements UpdateIncidentInputPort
{
    private $incidentRepository;

    public function __construct(IncidentRepositoryInterface $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function execute(int $incidentId, array $data): ?array
    {
        $update = $this->incidentRepository->update($incidentId, $data);
        return ($update) ? $this->incidentRepository->getIncident($incidentId) : null;
    }
}