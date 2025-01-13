<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\User;
use App\Port\Out\UserRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class UserRepository implements UserRepositoryInterface
{
    private DatabaseAdapterInterface $dbAdapter;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function save(User $user): void
    {
        $stmt = $this->dbAdapter->prepare("INSERT INTO users (email, password, name) VALUES (:email, :password, :name)");
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':password', $user->getPassword());
        $stmt->bindParam(':name', $user->getName());
        $stmt->execute();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->dbAdapter->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $data = $stmt->fetch();
        if ($data) {
            return new User($data['id'], $data['email'], $data['password'], $data['name']);
        }
        
        return null;
    }
}
