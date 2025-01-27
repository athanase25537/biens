<?php
namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\User;
use App\Port\Out\UserRepositoryInterface;
use App\Port\In\RegisterUserInputPort;

class RegisterUserUseCase implements RegisterUserInputPort
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password, string $name): User
    {
        //Hash du mot de passe avant de l'enregistrer
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $user = new User(0, $email, $hashedPassword, $name);
        $this->userRepository->save($user);

        return $user;
    }
}
