<?php

namespace App\Port\In\QuittanceLoyer;

use App\Core\Domain\Entity\QuittanceLoyer;

interface CreateQuittanceLoyerInputPort
{
    public function execute(array $data): QuittanceLoyer;
}