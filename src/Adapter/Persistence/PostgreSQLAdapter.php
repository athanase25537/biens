<?php
namespace App\Adapter\Persistence\Doctrine\DatabaseAdapter;

use PDO;
use App\Port\Out\DatabaseAdapterInterface;

class PostgreSQLAdapter implements DatabaseAdapterInterface {
    private $connection;

    public function connect(array $config): void {
        $dsn = "pgsql:host={$config['host']};dbname={$config['dbname']}";
        $this->connection = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    // Autres méthodes identiques à MySQLAdapter
    // ... (implementation des autres méthodes)
}