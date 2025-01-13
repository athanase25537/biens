<?php
namespace App\Port\Out;

interface DatabaseAdapterInterface
{
    public function prepare(string $query);
    public function execute(array $params = []): bool;
    public function fetch(): array;
}
