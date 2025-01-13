<?php
namespace App\Port\In;

interface RegisterUserInputPort
{
    public function execute(string $email, string $password, string $name);
}
