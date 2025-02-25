<?php

namespace App\Core\Application\UseCase\UserAbonnement;

use App\Core\Domain\Entity\UserAbonnement;
use App\Port\In\UserAbonnement\DeleteUserAbonnementInputPort;
use App\Port\Out\UserAbonnementRepositoryInterface;

class DeleteUserAbonnementUseCase implements DeleteUserAbonnementInputPort
{

    private $userAbonnementRepository;

    public function __construct(UserAbonnementRepositoryInterface $userAbonnementRepository)
    {
        $this->userAbonnementRepository = $userAbonnementRepository;
    }

    public function execute(int $userAbonnementId): void
    {
        try{
            $delete = $this->userAbonnementRepository->destroy($userAbonnementId);
        } catch(Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
}