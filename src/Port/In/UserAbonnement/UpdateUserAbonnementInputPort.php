<?php

namespace App\Port\In\UserAbonnement;

use App\Core\Domain\Entity\UserAbonnement;

interface UpdateUserAbonnementInputPort
{
    public function execute(int $userAbonnementId, array $data): ?array;
}