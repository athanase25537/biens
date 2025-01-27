<?php

namespace App\Adapter\Persistence;

use App\Port\Out\DatabaseAdapterInterface;
use PDO;

class PDOAdapter implements DatabaseAdapterInterface
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function prepare(string $query)
    {
        return $this->pdo->prepare($query);
    }

    public function execute(array $params = []): bool
    {
        return $this->pdo->execute($params);
    }

    public function fetch(): array
    {
        return $this->pdo->fetch(PDO::FETCH_ASSOC);
    }
}
