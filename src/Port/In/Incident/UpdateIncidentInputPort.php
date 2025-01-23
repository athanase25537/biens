<?php

namespace App\Port\In\Incident;

interface UpdateIncidentInputPort
{
    public function execute(int $etatLieuxId, array $data): ?array;
}