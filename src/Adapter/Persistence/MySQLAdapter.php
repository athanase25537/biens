<?php
namespace App\Adapter\Persistence\Doctrine\DatabaseAdapter;

use App\Port\Out\DatabaseAdapterInterface;
use PDO;

class MySQLAdapter implements DatabaseAdapterInterface {
    private $connection;

    public function connect(array $config): void {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
        $this->connection = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query(string $sql, array $params = []): array {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findOne(string $sql, array $params = []): ?array {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function execute(string $sql, array $params = []): bool {
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }

    public function lastInsertId(): string {
        return $this->connection->lastInsertId();
    }
}







// namespace App\Adapter\Persistence;

// use App\Port\Out\DatabaseAdapterInterface;
// use PDO;

// class MySQLAdapter implements DatabaseAdapterInterface
// {
//     private $pdo;

//     public function connect(): void
//     {
//         $host = 'localhost';
//         $dbname = 'bailonline';
//         $username = 'bailonline';
//         $password = '3NEeZuRailVisKB7V2Gr';

//         try {
//             $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//             $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (\PDOException $e) {
//             throw new \RuntimeException('Error connecting to MySQL: ' . $e->getMessage());
//         }
//     }

//     public function query(string $query, array $params = []): array
//     {
//         $stmt = $this->pdo->prepare($query);
//         $stmt->execute($params);
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }

//     public function prepare(string $query): object
//     {
//         return $this->pdo->prepare($query);
//     }
// }
