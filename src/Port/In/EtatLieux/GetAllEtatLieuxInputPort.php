<?php

namespace App\Port\In\EtatLieux;

interface GetAllEtatLieuxInputPort
{
    public function execute(int $offset): ?array;
}