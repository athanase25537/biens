<?php

namespace App\Port\In\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;

interface UpdateQuittanceLoyerInputPort
{
    public function execute(int $quittanceLoyerId, array $data): ?array;
}