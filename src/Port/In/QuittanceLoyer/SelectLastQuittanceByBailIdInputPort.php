<?php

namespace App\Port\In\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;

interface SelectLastQuittanceByBailIdInputPort
{
    public function execute(int $bailId): ?array;
}