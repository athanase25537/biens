<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\RegisterUserUseCase;
use App\Core\Application\UseCase\LoginUserUseCase;

class AuthController
{
    private $registerUserUseCase;
    private $loginUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase, LoginUserUseCase $loginUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
    }

    public function register()
    {

        $data = json_decode(file_get_contents('php://input'), true);
        $user = $this->registerUserUseCase->execute($data['email'], $data['password'], $data['name']);
        
        $this->sendResponse('User registered successfully', 201);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $user = $this->loginUserUseCase->execute($data['email'], $data['password']);

        if ($user) {
            $this->sendResponse('Login successful', 200);
        } else {
            $this->sendResponse('Email ou mot de passe incorrect', 401);
        }
    }

    private function sendResponse($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode(['message' => $message]);
    }
}
