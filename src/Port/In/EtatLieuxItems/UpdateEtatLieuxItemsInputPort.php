<?php

namespace App\Port\In\EtatLieuxItems;

interface UpdateEtatLieuxItemsInputPort
{
    public function execute(int $etatLieuxItemsId, array $data): ?array;
}