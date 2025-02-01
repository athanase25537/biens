<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\UserAbonnement;

interface UserAbonnementRepositoryInterface
{
    public function save(UserAbonnement $data): UserAbonnement;
    public function update(int $userAbonnement, array $data): bool;
    // public function getEtatLieuxItems(int $etatLieuxItemsId): ?array;
    // public function destroy(int $etatLieuxItemsId, int $etatLieuxId): bool;
}