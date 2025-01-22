<?php

namespace App\Port\In\EtatLieux;

use App\Core\Domain\Entity\EtatLieux;

interface CreateEtatLieuxInputPort
{
    public function execute(array $data): EtatLieux;
}