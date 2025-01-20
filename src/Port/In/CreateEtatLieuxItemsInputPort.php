<?php

namespace App\Port\In;

use App\Core\Domain\Entity\EtatLieuxItems;

interface CreateEtatLieuxItemsInputPort
{
    public function execute(array $data): EtatLieuxItems;
}