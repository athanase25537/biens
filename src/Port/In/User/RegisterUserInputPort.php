<?php
namespace App\Port\In\User;

interface RegisterUserInputPort
{
    public function execute(array $data);
}