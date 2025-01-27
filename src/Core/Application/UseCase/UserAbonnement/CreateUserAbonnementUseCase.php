<?php

namespace App\Core\Application\UseCase\UserAbonnement;

use App\Core\Domain\Entity\UserAbonnement;
use App\Port\In\UserAbonnement\CreateUserAbonnementInputPort;
use App\Port\Out\UserAbonnementRepositoryInterface;

class CreateUserAbonnementUseCase implements CreateUserAbonnementInputPort
{

    private $userAbonnementRepository;

    public function __construct(UserAbonnementRepositoryInterface $userAbonnementRepository)
    {
        $this->userAbonnementRepository = $userAbonnementRepository;
    }

    public function execute(array $data): UserAbonnement
    {
        $userAbonnement = new UserAbonnement(
            (int)$data['user_id'],
            (int)$data['abonnement_id'],
            (int)$data['payments_id'],
            $data['type_formule'],
            (float)$data['prix_ht'],
            (float)$data['tva_rate'],
            (float)$data['montant_tva'],
            (float)$data['montant_ttc'],
            new \DateTime($data['date_acquisition']),
            new \DateTime($data['date_expiration']),
            $data['statut'],
            $data['suivi'] ?? null,
            new \DateTime($data['created_at']),
            new \DateTime($data['updated_at'])
        );

        $userAbonnement = $this->userAbonnementRepository->save($userAbonnement);
        return $userAbonnement;
    }
}