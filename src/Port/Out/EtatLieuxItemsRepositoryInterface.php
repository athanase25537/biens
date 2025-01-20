<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\EtatLieuxItems;

interface EtatLieuxItemsRepositoryInterface
{
    public function save(EtatLieuxItems $etatLieuxItems): EtatLieuxItems;
}