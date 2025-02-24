<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\QuittanceLoyer;

interface QuittanceLoyerRepositoryInterface
{
    public function save(QuittanceLoyer $quittanceLoyer): QuittanceLoyer;
    public function update(int $quittanceLoyerId, array $data): bool;
    public function destroy(int $quittanceLoyerId, int $bailId): bool;
    // public function getQuittanceLoyer(int $quittanceLoyerId): ?array;
    public function selectLastQuittanceByBailId(int $bailId): ?array;
}