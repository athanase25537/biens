<?php

namespace App\Port\In\UserAbonnement;

use App\Core\Domain\Entity\UserAbonnement;

interface CreateUserAbonnementInputPort
{
    public function execute(array $data): UserAbonnement;
}