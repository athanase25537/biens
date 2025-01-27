<?php

namespace App\Port\In;

interface DeleteBienImmobilierInputPort
{
    public function execute(int $idBienImmobilier): void;
}