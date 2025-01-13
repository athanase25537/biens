<?php
namespace App\Adapter\Persistence;

use App\Port\Out\DatabaseAdapterInterface;
use PDO;

class SQLiteAdapter implements DatabaseAdapterInterface
{
    private $pdo;

    public function connect(): void
    {
        $path = 'sqlite:/lien_vers_ma_db/ma_database.db';
        try {
            $this->pdo = new PDO($path);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error connecting to SQLite: ' . $e->getMessage());
        }
    }

    public function query(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prepare(string $query): object
    {
        return $this->pdo->prepare($query);
    }
}
