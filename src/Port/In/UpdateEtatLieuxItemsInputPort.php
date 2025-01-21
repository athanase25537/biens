<?php

namespace App\Port\In;

interface UpdateEtatLieuxItemsInputPort
{
    public function execute(int $etatLieuxItemsId, array $data): ?array;
}