<?php

namespace App\Adapter\Persistence;

use App\Port\Out\DatabaseAdapterInterface;

class MySQLAdapter implements DatabaseAdapterInterface {
    private $connection;

    public function connect(array $config): void {
      //var_dump($config);
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
    public function execute(string $query, array $params = []): bool
    {
        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            throw new \Exception("Failed to prepare statement: " . $this->connection->error);
        }

        if (!empty($params)) {
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
        }

        $success = $stmt->execute();

        if (!$success) {
            throw new \Exception("Failed to execute statement: " . $stmt->error);
        }

        $stmt->close();
        return $success;
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
      public function lastInsertId(): int
    {
       	return $this->connection->insert_id;
    }
  	public function persist(string $table, array $data): void
	{
      $columns = implode(", ", array_keys($data));
      $placeholders = implode(", ", array_fill(0, count($data), "?"));

      $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

      $stmt = $this->connection->prepare($query);

      if (!$stmt) {
          throw new \Exception("Failed to prepare statement: " . $this->connection->error);
      }

      $types = str_repeat("s", count($data)); 
      $stmt->bind_param($types, ...array_values($data));

      $success = $stmt->execute();

      if (!$success) {
          throw new \Exception("Failed to execute statement: " . $stmt->error);
      }

      $stmt->close();
	}

}
