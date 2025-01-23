<?php
namespace App\Core\Application\UseCase\User;

use App\Core\Domain\Entity\User;
use App\Port\In\User\RegisterUserInputPort;
use App\Port\Out\UserRepositoryInterface;

class RegisterUserUseCase implements RegisterUserInputPort
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data): User
    {
        $user = new User(
            (int)$data['id_parrain'],
            $data['username'],
            $data['photo'],
            $data['email'],
            $data['portable'],
            $data['password'],
            $data['role'],
            $data['nom'],
            $data['prenom']
        );

        $user = $this->userRepository->save($user);
        return $user;
    }
}