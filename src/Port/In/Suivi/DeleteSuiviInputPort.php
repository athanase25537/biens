<?php

namespace App\Port\In\Suivi;

interface DeleteSuiviInputPort
{
    public function execute(int $suiviId, int $bailId): void;
}