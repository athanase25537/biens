<?php

namespace App\Controllers;

use App\UseCases\CreateUserUseCase;

class UserController
{
    private CreateUserUseCase $createUserUseCase;

    public function __construct(CreateUserUseCase $createUserUseCase)
    {
        $this->createUserUseCase = $createUserUseCase;
    }

    public function createUser(array $data)
    {
        $user = $this->createUserUseCase->execute($data);

        return json_encode([
            'status' => 'success',
            'user_id' => $user->getId(),
            'username' => $user->getUsername(),
        ]);
    }
}
