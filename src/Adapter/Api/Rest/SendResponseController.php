<?php

namespace App\Adapter\Api\Rest;

class SendResponseController
{
    public static function sendResponse($message, $statusCode)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode(['message' => $message]);
    }
}
