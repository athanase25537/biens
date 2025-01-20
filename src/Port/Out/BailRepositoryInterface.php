<?php
namespace App\Port\Out;

use App\Core\Domain\Entity\Bail;

interface BailRepositoryInterface
{
    public function save(Bail $bail): Bail;
    public function findById(int $id): ?Bail;
    public function findAll(): array;
    public function delete(int $id): void;
}
