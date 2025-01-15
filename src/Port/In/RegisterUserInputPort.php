<?php
namespace App\Port\In;

interface RegisterUserInputPort
{
    public function execute(array $data);
}