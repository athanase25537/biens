<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\Signature;

interface SignatureRepositoryInterface
{
    public function save(Signature $signature): int;
    public function findById(int $id): ?Signature;
}
