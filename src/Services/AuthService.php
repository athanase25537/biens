<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    public function login(array $data)
    {

        if ($data['email'] === 'test@example.com' && $data['password'] === 'password') {
            return ['status' => 'success', 'message' => 'Login successful'];
        }
        return ['status' => 'error', 'message' => 'Invalid credentials'];
    }

    public function register(array $data)
    {

        $user = new User($data['email'], $data['password']);
        return ['status' => 'success', 'message' => 'User registered successfully', 'user' => $user];
    }
}
