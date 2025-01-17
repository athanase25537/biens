
<?php
namespace App\Port\Out;

interface BailRepositoryInterface
{
    public function save(Bail $bail): int;
    public function findById(int $id): ?Bail;
    public function findAll(): array;
    public function delete(int $id): void;
}
