<?php

namespace App\Port\In\BienImmobilier;

interface GetAllBienImmobilierInputPort
{
    public function execute(int $offset): ?array;
}