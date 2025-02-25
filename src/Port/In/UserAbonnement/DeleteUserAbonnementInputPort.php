<?php

namespace App\Port\In\UserAbonnement;

interface DeleteUserAbonnementInputPort
{
    public function execute(int $userAbonnementId): void;
}