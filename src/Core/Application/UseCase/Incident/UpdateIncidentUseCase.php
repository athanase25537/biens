<?php

namespace App\Core\Application\UseCase\Incident;

use App\Core\Domain\Entity\Incident;
use App\Port\In\UpdateIncidentInputPort;
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