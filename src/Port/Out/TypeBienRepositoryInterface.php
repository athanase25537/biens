<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\TypeBien;

interface TypeBienRepositoryInterface
{
    public function save(TypeBien $typeBien): TypeBien;
    public function update(int $typeBienId, array $data): bool;
    public function getTypeBien(int $typeBienId): ?array;
}