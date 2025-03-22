<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\User\LoginUserUseCase;
use App\Core\Application\UseCase\User\RegisterUserUseCase;
use App\Core\Application\UseCase\User\AuthGoogleUseCase;

class AuthController
{
    private $registerUserUseCase;
    private $loginUserUseCase;
    private $authGoogleUseCase;
    private SendResponseController $sendResponseController;

    public function __construct(
        RegisterUserUseCase $registerUserUseCase, 
        LoginUserUseCase $loginUserUseCase,
        AuthGoogleUseCase $authGoogleUseCase
        )
    {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
        $this->authGoogleUseCase = $authGoogleUseCase;
        $this->sendResponseController = new SendResponseController();
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $user = $this->registerUserUseCase->execute($data);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }
        
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
        $this->sendResponseController::sendResponse($response, 201);
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $user = $this->loginUserUseCase->execute($data['email'], $data['password']);
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        if ($user) {
            $response = 'Login successful';
            $statusCode = 200;
        } else {
            $response = 'Email or password incorrect';
            $statusCode = 401;
        }

        $this->sendResponseController::sendResponse($response, $statusCode);
    }

    public function auth_google()
    {
        try {
            $statusCode = 200;
            $response = $this->authGoogleUseCase->connect();
        } catch(\Exception $e) {
            $statusCode = 401;
            echo "Erreur: " . $e->getMessage();
            return;
        }

        $this->sendResponseController::sendResponse($response, $statusCode);
    }

    public function auth_google_check()
    {
        try {
            $response = $this->authGoogleUseCase->checkLogin();
        } catch(\Exception $e) {
            echo "Erreur: " . $e->getMessage();
            return;
        }

        $this->sendResponseController::sendResponse($response, $statusCode);
    }
}