<?php

namespace App\Port\In;

use App\Core\Domain\Entity\EtatLieux;

interface CreateEtatLieuxInputPort
{
    public function execute(array $data): EtatLieux;
}