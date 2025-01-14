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
            "INSERT INTO users (id_parrain, username, photo, email, portable, password, role, nom, prenom, is_active, last_login, created_at, updated_at) 
            VALUES (:id_parrain, :username, :photo, :email, :portable, :password, :role, :nom, :prenom, :is_active, :last_login, :created_at, :updated_at)"
        );

        $stmt->execute([
            ':id_parrain' => $user->getParrainId(),
            ':username' => $user->getUsername(),
            ':photo' => $user->getPhoto(),
            ':email' => $user->getEmail(),
            ':portable' => $user->getPhone(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRules(),
            ':nom' => $user->getName(),
            ':prenom' => $user->getFirstname(),
            ':is_active' => $user->isActive(),
            ':last_login' => $user->getLastLogin()->format('Y-m-d H:i:s'),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ':updated_at' => $user->getUpdatedAt()->format('Y-m-d H:i:s')
        ]);

        $user->setId((int) $this->pdo->lastInsertId());

        return $user;
    }
}
