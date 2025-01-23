<?php
namespace App\Core\Application\UseCase\User;

use App\Core\Domain\Entity\User;
use App\Port\In\User\LoginUserInputPort;
use App\Port\Out\UserRepositoryInterface;

class LoginUserUseCase implements LoginUserInputPort
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): ?User
    {
        $user = $this->userRepository->findByEmail($email);
        
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }

        return null;
    }
}