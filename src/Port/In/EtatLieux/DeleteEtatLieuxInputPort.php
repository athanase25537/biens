<?php

namespace App\Port\In\EtatLieux;

interface DeleteEtatLieuxInputPort
{
    public function execute(int $etatLieuxId, int $bauxId): void;
}