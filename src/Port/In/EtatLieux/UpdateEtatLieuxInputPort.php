<?php

namespace App\Port\In\EtatLieux;

use App\Core\Domain\Entity\EtatLieux;

interface UpdateEtatLieuxInputPort
{
    public function execute(int $etatLieuxId, array $data): ?array;
}