<?php

namespace App\Port\In\TypeBien;

interface UpdateTypeBienInputPort
{
    public function execute(int $etatLieuxId, array $data): ?array;
}