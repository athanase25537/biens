<?php

namespace App\Port\In\Bail;

interface GetAllBailInputPort
{
    public function execute(int $offset): ?array;
}