<?php

namespace App\Port\In\Suivi;

use App\Core\Domain\Entity\Suivi;

interface CreateSuiviInputPort
{
    public function execute(array $data): Suivi;
}