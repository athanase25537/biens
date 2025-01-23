<?php

namespace App\Port\In\EtatLieuxItems;

interface DeleteEtatLieuxItemsInputPort
{
    public function execute(int $etatLieuxItemsId, int $etatLieuxId): void;
}