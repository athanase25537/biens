<?php

namespace App\Port\In\Suivi;

interface UpdateSuiviInputPort
{
    public function execute(int $suiviId, array $data): ?array;
}