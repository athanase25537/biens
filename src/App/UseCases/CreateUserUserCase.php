<?php

namespace App\UseCases;

use App\Entities\User;
use App\Repositories\UserRepositoryInterface;

class CreateUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        $user = new User(
            $data['parrain_id'],
            $data['username'],
            $data['photo'],
            $data['email'],
            $data['phone'],
            $data['password'],
            $data['rules'],
            $data['name'],
            $data['firstname']
        );

        return $this->userRepository->save($user);
    }
}
