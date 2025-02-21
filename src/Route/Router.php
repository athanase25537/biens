<?php

namespace App\Route;

class Router {

    private $routes = [];
    public function addRoute($method, $pattern, $callback) 
    {
        $this->routes[] = [
            'method' => $method, 
            'pattern' => $pattern, 
            'callback' => $callback
        ];
    }

    public function handleRequest($requestUri, $requestMethod) 
    {
        session_start();
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && preg_match($route['pattern'], $requestUri, $matches)) {
                // Vérifier si l'utilisateur est connecté, sauf pour la route "login"
                $callback = $route['callback'][1];
                if ($callback !== 'login' && !isset($_SESSION['user'])) {
                    // header("Location: /login");
                    exit;
                }
                
                try {
                    array_shift($matches);
                    call_user_func_array($route['callback'], $matches);
                } catch (Exception $e) {
                    $this->sendResponse(['success' => false, 'error' => $e->getMessage()], 500);
                }
                return;
            }            
        }

        $this->sendResponse(['success' => false, 'error' => 'Route Not Found'], 404);

    }
    

    private function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}