<?php

namespace App\Port\Out;

interface DatabaseAdapterInterface {
    public function connect(array $config): void;
    public function query(string $sql, array $params = []): array;
    public function close(): void;
  	public function lastInsertId(): int;
}
