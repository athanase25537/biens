<?php

namespace App\Core\Application\UseCase\Incident;

use App\Core\Domain\Entity\Incident;
use App\Port\In\Incident\GetAllIncidentInputPort;
use App\Port\Out\IncidentRepositoryInterface;

class GetAllIncidentUseCase implements GetAllIncidentInputPort
{

    private $incidentRepository;

    public function __construct(IncidentRepositoryInterface $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function execute(int $offset): ?array
    {
        return $this->incidentRepository->getAllIncident($offset);
    }
}