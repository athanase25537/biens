<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\User;
use App\Port\Out\UserRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class UserRepository implements UserRepositoryInterface {
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter) {
        $this->db = $dbAdapter;
    }

    public function findByEmail(string $email): ?array {
        return $this->db->findOne(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
    }

    public function save(User $user): void {
        $this->db->execute(
            "INSERT INTO users (email, password, name) VALUES (?, ?, ?)",
            [$user->getEmail(), $user->getPassword(), $user->getName()]
        );
    }
}
