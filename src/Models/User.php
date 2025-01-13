<?php

namespace App\Models;

class User
{
    public string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}
