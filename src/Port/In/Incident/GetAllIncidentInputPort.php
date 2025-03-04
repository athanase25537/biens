<?php

namespace App\Port\In\Incident;

interface GetAllIncidentInputPort
{
    public function execute(int $offset): ?array;
}