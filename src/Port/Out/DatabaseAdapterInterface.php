<?php
namespace App\Port\Out;

interface DatabaseAdapterInterface {
    public function connect(array $config);
    public function query(string $sql, array $params = []): array;
    public function findOne(string $email): ?array;
    public function execute(string $sql, array $params = []): bool;
    public function lastInsertId(): string;
}