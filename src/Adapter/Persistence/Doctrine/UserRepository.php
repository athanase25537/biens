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
        $stmt = $this->dbAdapter->prepare("
            INSERT INTO users (email, password, portable, nom, prenom, role, is_active)
            VALUES (:email, :password, :portable, :nom, :prenom, :role, :is_active)
        ");
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':password', $user->getPassword());
        $stmt->bindParam(':portable', $user->getPortable());
        $stmt->bindParam(':nom', $user->getNom());
        $stmt->bindParam(':prenom', $user->getPrenom());
        $stmt->bindParam(':role', $user->getRole());
        $stmt->bindParam(':is_active', $user->isActive(), \PDO::PARAM_BOOL);
        $stmt->execute();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->dbAdapter->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $data = $stmt->fetch();
        if ($data) {
            return new User(
                $data['id'],
                $data['email'],
                $data['password'],
                $data['portable'],
                $data['nom'],
                $data['prenom'],
                $data['role'],
                (bool) $data['is_active'],
                $data['last_login'] ? new \DateTime($data['last_login']) : null,
                new \DateTime($data['created_at']),
                new \DateTime($data['updated_at'])
            );
        }

        return null;
    }
}
