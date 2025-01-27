<?php

namespace App\Port\In;

use App\Core\Domain\Entity\TypeBien;

interface CreateTypeBienInputPort
{
    public function execute(array $data): TypeBien;
}