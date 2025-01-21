<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\EtatLieuxItems;

interface EtatLieuxItemsRepositoryInterface
{
    public function save(EtatLieuxItems $etatLieuxItems): EtatLieuxItems;
    public function update(int $etatLieuxItemsId, array $data): bool;
    public function getEtatLieuxItems(int $etatLieuxItemsId): ?array;
    public function destroy(int $etatLieuxItemsId, int $etatLieuxId): bool;
}