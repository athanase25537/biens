<?php

namespace App\Port\In;

use App\Core\Domain\Entity\Bail;

interface UpdateBailImmobilierInputPort
{
    public function execute(int $idBailImmobilier, array $data): ?array;
}