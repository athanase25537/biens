<?php

namespace App\Port\In\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;

interface DeleteQuittanceLoyerInputPort
{
    public function execute(int $quittanceLoyerId, $bailId): ?array;
}