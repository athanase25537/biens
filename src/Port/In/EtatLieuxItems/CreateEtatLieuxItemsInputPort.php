<?php

namespace App\Port\In\EtatLieuxItems;

use App\Core\Domain\Entity\EtatLieuxItems;

interface CreateEtatLieuxItemsInputPort
{
    public function execute(array $data): EtatLieuxItems;
}