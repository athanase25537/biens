<?php

namespace App\Port\In;

use App\Core\Domain\Entity\Garant;

interface UpdateGarantImmobilierInputPort
{
    public function execute(int $idGarantImmobilier, array $data): ?array;
}