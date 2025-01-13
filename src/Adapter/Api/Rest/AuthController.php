<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\RegisterUserUseCase;
use App\Core\Application\UseCase\LoginUserUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController
{
    private $registerUserUseCase;
    private $loginUserUseCase;

    public function __construct(RegisterUserUseCase $registerUserUseCase, LoginUserUseCase $loginUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
    }

    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->registerUserUseCase->execute($data['email'], $data['password'], $data['name']);
        
        return new Response('User registered successfully', Response::HTTP_CREATED);
    }

    public function login(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $user = $this->loginUserUseCase->execute($data['email'], $data['password']);

        if ($user) {
            return new Response('Login successful', Response::HTTP_OK);
        }

        return new Response('Invalid credentials', Response::HTTP_UNAUTHORIZED);
    }
}
