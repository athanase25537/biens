<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\TypeBien;

interface TypeBienRepositoryInterface
{
    public function save(TypeBien $typeBien): TypeBien;
}