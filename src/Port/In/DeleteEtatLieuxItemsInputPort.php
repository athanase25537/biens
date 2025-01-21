<?php

namespace App\Port\In;

interface DeleteEtatLieuxItemsInputPort
{
    public function execute(int $etatLieuxItemsId, int $etatLieuxId): void;
}