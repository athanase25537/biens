<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\EtatLieux;

interface EtatLieuxRepositoryInterface
{
    public function save(EtatLieux $etatLieux): EtatLieux;
    public function update(int $etatLieuxId, array $data): bool;
    public function destroy(int $etatLieuxId, int $bauxId): bool;
}