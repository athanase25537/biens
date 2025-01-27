<?php
namespace Port\Out;

interface SignatureRepositoryInterface
{
    public function save(Signature $signature): void;
    public function findById(int $id): ?Signature;
    public function findByBailId(int $bauxId): array;
}
