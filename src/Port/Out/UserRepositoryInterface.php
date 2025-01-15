<?php
namespace App\Port\Out;

use App\Core\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function findByEmail(string $email): ?array;
}