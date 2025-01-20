<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\Incident;

interface IncidentRepositoryInterface
{
    public function save(Incident $incident): Incident;
}