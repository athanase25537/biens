<?php

namespace App\Adapter\Persistence;

use App\Port\Out\DatabaseAdapterInterface;

class MySQLAdapter implements DatabaseAdapterInterface {
    private $connection;

    public function connect(array $config): void {
        $this->connection = new \mysqli(
            $config['host'],
            $config['user'],
            $config['password'],
            $config['dbname']
        );

        if ($this->connection->connect_error) {
            throw new \Exception("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function query(string $query, array $params = []): array {
        $stmt = $this->connection->prepare($query);
        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new \Exception("Query failed: " . $this->connection->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
      public function findOne($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public function close(): void {
        $this->connection->close();
    }
    public function execute(string $query, array $params = []): bool
    {
        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->connection->error);
        }

        if (!empty($params)) {
            $types = str_repeat("s", count($params)); // Ajustez les types selon vos besoins
            $stmt->bind_param($types, ...$params);
        }

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();
        return $success;
    }
    public function lastInsertId(): int
    {
        return $this->connection->insert_id;
    }   

}
