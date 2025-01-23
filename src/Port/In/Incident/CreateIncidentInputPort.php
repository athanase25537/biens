<?php

namespace App\Port\In\Incident;

use App\Core\Domain\Entity\Incident;

Interface CreateIncidentInputPort
{
    public function execute(array $data): Incident;
}