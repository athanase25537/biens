<?php

namespace App\Adapter\Persistence;

use App\Port\Out\DatabaseAdapterInterface;

class MySQLAdapter implements DatabaseAdapterInterface {
    private $connection;

    public function connect(array $config) {
		
		$port = isset($config['port']) ? (int)$config['port'] : 3306;

        $this->connection = new \mysqli(
            $config['host'],
            $config['user'],
	        $config['password'],
            $config['dbname'],
	        $port
        );

        if ($this->connection->connect_error) {
            throw new \Exception("Connection failed: " . $this->connection->connect_error);
        }
        return $this->connection;
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
    
    public function findOne(string $email): ?array
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$email]);

        return $stmt->fetch();
    }

    public function close(): void {
        $this->connection->close();
    }

    public function execute(string $sql, array $params = []): bool
    {
        $response = true;
        $stmt = $this->connection->prepare($query);
        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $response = false;
        }

        return $response;
    }

    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
