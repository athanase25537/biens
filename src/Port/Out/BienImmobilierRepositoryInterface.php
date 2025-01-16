<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\BienImmobilier;

interface BienImmobilierRepositoryInterface
{
    public function save(BienImmobilier $bienImmobilier): BienImmobilier;
}