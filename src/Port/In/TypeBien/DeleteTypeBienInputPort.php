<?php

namespace App\Port\In\TypeBien;

interface DeleteTypeBienInputPort
{
    public function execute(int $etatLieuxId): void;
}