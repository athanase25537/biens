<?php
namespace App\Port\In;

interface LoginUserInputPort
{
    public function execute(string $email, string $password);
}