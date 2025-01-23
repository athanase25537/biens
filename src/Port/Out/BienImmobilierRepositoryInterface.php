<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\BienImmobilier;

interface BienImmobilierRepositoryInterface
{
    public function save(BienImmobilier $bienImmobilier): BienImmobilier;
    public function getBienImmobilier(int $id): ?BienImmobilier;
    public function update(int $idBienImmobilier, array $data): bool;
    public function destroy(int $idBienImmobilier): bool;
}