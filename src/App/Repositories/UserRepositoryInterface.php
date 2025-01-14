<?php

namespace App\Repositories;

use App\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
}
