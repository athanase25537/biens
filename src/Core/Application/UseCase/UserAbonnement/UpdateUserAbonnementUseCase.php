<?php

namespace App\Core\Application\UseCase\UserAbonnement;

use App\Core\Domain\Entity\UseAbonnement;
use App\Port\In\UserAbonnement\UpdateUserAbonnementInputPort;
use App\Port\Out\UserAbonnementRepositoryInterface;

class UpdateUserAbonnementUseCase implements UpdateUserAbonnementInputPort
{

    private $userAbonnementRepository;

    public function __construct(UserAbonnementRepositoryInterface $userAbonnementRepository)
    {
        $this->userAbonnementRepository = $userAbonnementRepository;
    }

    public function execute(int $userAbonnementId, array $data): ?array
    {
        $update = $this->userAbonnementRepository->update($userAbonnementId, $data);
        return ($update) ? $this->userAbonnementRepository->getUserAbonnement($userAbonnementId) : null;
    }
}