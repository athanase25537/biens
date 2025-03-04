<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\Incident;

interface IncidentRepositoryInterface
{
    public function save(Incident $incident): Incident;
    public function update(int $incidentId, array $data): bool;
    public function destroy(int $incidentId, int $bienId, int $bailId): bool;
    public function getIncident(int $incidentId): ?array;
    public function getAllIncident(int $offset): ?array;
}