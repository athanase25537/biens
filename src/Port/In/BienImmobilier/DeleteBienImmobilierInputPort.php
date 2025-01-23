<?php

namespace App\Port\In\BienImmobilier;

interface DeleteBienImmobilierInputPort
{
    public function execute(int $idBienImmobilier): void;
}