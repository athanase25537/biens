<?php
namespace App\Port\Out;

interface DatabaseAdapterInterface {
    public function connect(array $config): void;
    public function query(string $sql, array $params = []): array;
    public function findOne(string $sql, array $params = []): ?array;
    public function execute(string $sql, array $params = []): bool;
    public function lastInsertId(): string;
}
