<?php

namespace App\Port\In;

use App\Core\Domain\Entity\BienImmobilier;

interface UpdateBienImmobilierInputPort
{
    public function execute(int $idBienImmobilier, array $data): ?array;
}