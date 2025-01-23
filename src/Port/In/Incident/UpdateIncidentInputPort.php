<?php

namespace App\Port\In\Incident;

interface UpdateIncidentInputPort
{
    public function execute(int $incidentId, array $data): ?array;
}