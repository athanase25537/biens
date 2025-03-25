<?php

namespace App\Route;

use App\Controller\HomeController;

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
        session_destroy();

        $allowed_end_point = explode(",", $_ENV['ALLOWED_END_POINT']);
        foreach ($this->routes as $route) {
            $uriWithoutQuery = strtok($requestUri, '?'); // Ignore les query strings
            if ($route['method'] === $requestMethod && preg_match('#^' . $route['pattern'] . '$#', $uriWithoutQuery, $matches)) {
                echo "eto";
                if (!in_array($route['callback'][1], $allowed_end_point) && !isset($_SESSION['user'])) {
                    return header('Location: /login');
                }
                
                try {
                    call_user_func_array($route['callback'], $matches);
                } catch (Exception $e) {
                    $this->sendResponse(['error' => $e->getMessage()], 500);
                }
                return;
            }
        }
        
        $controller = new HomeController();
        $controller->not_found();

    }
    

    private function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}