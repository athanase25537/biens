<?php
namespace App\Port\Out;

use App\Core\Domain\Entity\Garant;

interface GarantRepositoryInterface
{
    public function save(Bail $bail): Garant;
    public function findById(int $id): ?Garant;
    public function findAll(): array;
    public function delete(int $id): bool;
}
