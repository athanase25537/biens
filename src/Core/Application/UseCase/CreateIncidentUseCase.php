<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Incident;
use App\Port\In\CreateIncidentInputPort;
use App\Port\Out\IncidentRepositoryInterface;

class CreateIncidentUseCase implements CreateIncidentInputPort
{
    private $incidentRepository;

    public function __construct(IncidentRepositoryInterface $incidentRepository)
    {
        $this->incidentRepository = $incidentRepository;
    }

    public function execute(array $data): Incident
    {
        $incident = new Incident(
            $data['bien_id'],
            $data['bail_id'],
            $data['description'],
            $data['statut'],
            new \DateTime($data['date_signalement']),
            new \DateTime($data['date_resolution']),
        );

        $incident = $this->incidentRepository->save($incident);
        return $incident;
    }
}