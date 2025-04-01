<?php

namespace App\Port\In\BienImmobilier;

interface GetBienImmobilierInputPort
{
    public function execute(int $idBienImmobilier): ?array;
}