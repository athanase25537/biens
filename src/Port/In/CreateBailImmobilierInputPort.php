<?php

namespace App\Port\In;

use App\Core\Domain\Entity\Bail;

interface CreateBailImmobilierInputPort
{
    public function execute(array $data): Bail;
}