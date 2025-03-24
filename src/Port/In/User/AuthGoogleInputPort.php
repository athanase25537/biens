<?php

namespace App\Port\In\User;

interface AuthGoogleInputPort
{
    public function connect() ;
    public function checkLogin();
}
