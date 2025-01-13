<?php

namespace App\Repositories;

use App\Entities\User;
use PDO;

class MySQLUserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): User
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (parrain_id, username, photo, email, phone, password, rules, name, firstname, is_active, last_login, created_at, updated_at) 
            VALUES (:parrain_id, :username, :photo, :email, :phone, :password, :rules, :name, :firstname, :is_active, :last_login, :created_at, :updated_at)"
        );

        $stmt->execute([
            ':parrain_id' => $user->getParrainId(),
            ':username' => $user->getUsername(),
            ':photo' => $user->getPhoto(),
            ':email' => $user->getEmail(),
            ':phone' => $user->getPhone(),
            ':password' => $user->getPassword(),
            ':rules' => $user->getRules(),
            ':name' => $user->getName(),
            ':firstname' => $user->getFirstname(),
            ':is_active' => $user->isActive(),
            ':last_login' => $user->getLastLogin()->format('Y-m-d H:i:s'),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s')
        ]);

        $user->setId((int) $this->pdo->lastInsertId());

        return $user;
    }
}
