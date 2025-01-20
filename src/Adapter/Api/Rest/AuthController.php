<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\LoginUserUseCase;
use App\Core\Application\UseCase\RegisterUserUseCase;

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
        $user = $this->registerUserUseCase->execute($data);
        
        // Response structure
        $response = [
            'message' => 'Utilisateur enregistré avec succès',
            'user' => [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'role' => $user->getRules(),
            'name' => $user->getName(),
            'firstname' => $user->getFirstname(),
            'is_active' => $user->isActive(),
            ],
        ];

        // Sending response
        $this->sendResponse($response, 201);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $user = $this->loginUserUseCase->execute($data['email'], $data['password']);

        if ($user) {
            $this->sendResponse('Login successful', 200);
        } else {
            $this->sendResponse('Invalid credentials', 401);
        }
    }

    private function sendResponse($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode(['message' => $message]);
    }
}