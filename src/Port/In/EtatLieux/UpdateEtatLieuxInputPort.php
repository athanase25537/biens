<?php

namespace App\Port\In\EtatLieux;

interface UpdateEtatLieuxInputPort
{
    public function execute(int $etatLieuxId, array $data): ?array;
}