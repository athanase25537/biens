<?php

namespace App\Port\In\Incident;

interface DeleteIncidentInputPort
{
    public function execute(int $incidentId, int $bienId, int $bailId): void;
}