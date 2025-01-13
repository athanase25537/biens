<?php
namespace App\Adapter\Persistence;

use App\Port\Out\DatabaseAdapterInterface;
use PDO;

class MySQLAdapter implements DatabaseAdapterInterface
{
    private $pdo;

    public function connect(): void
    {
        $host = 'localhost';
        $dbname = 'bailonline';
        $username = 'bailonline';
        $password = '3NEeZuRailVisKB7V2Gr';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \RuntimeException('Error connecting to MySQL: ' . $e->getMessage());
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
