<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\Suivi;

interface SuiviRepositoryInterface
{
    public function save(Suivi $suivi): Suivi;
    public function update(int $suiviId, array $data): bool;
    public function destroy(int $suiviId, int $bailId): bool;
    // public function getSuivi(int $suiviId): ?array;
}