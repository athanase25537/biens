<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Core\Request;

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(Request $request)
    {
        $data = $request->getBody();
        $response = $this->authService->login($data);
        echo json_encode($response);
    }

    public function register(Request $request)
    {
        $data = $request->getBody();
        $response = $this->authService->register($data);
        echo json_encode($response);
    }
}
