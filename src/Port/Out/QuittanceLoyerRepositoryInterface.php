<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\QuittanceLoyer;

interface QuittanceLoyerRepositoryInterface
{
    public function save(QuittanceLoyer $incident): QuittanceLoyer;
    // public function update(int $incidentId, array $data): bool;
    // public function destroy(int $incidentId, int $bienId, int $bailId): bool;
    // public function getIncident(int $incidentId): ?array;
}