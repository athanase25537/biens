<?php
namespace App\Port\In\User;

interface LoginUserInputPort
{
    public function execute(string $email, string $password): ?array;
}