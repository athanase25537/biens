<?php
namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Signature;
use App\Port\Out\SignatureRepositoryInterface;

class SignatureRepository implements SignatureRepositoryInterface
{
    public function save(Signature $signature): int
    {

    }

    public function findById(int $id): ?Signature
    {

    }
}
