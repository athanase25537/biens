<?php

namespace App\Port\In;

use App\Core\Domain\Entity\BienImmobilier;

interface CreateBienImmobilierInputPort
{
    public function execute(array $data): BienImmobilier;
}