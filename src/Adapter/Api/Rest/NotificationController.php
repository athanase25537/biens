<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\SendNotificationUseCase;

class NotificationController
{
    private SendNotificationUseCase $sendNotificationUseCase;

    public function __construct(SendNotificationUseCase $sendNotificationUseCase)
    {
        $this->sendNotificationUseCase = $sendNotificationUseCase;
    }

    public function send()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            $userId = $data['user_id'] ?? null;
            $type = $data['type_notification'] ?? null;
            $contenu = $data['contenu'] ?? null;
            $tokenPortable = $data['token_portable'] ?? null;

            if (!$userId || !$type || !$contenu || !$tokenPortable) {
                throw new \Exception("Données invalides");
            }

            $notification = $this->sendNotificationUseCase->execute($userId, $type, $contenu, $tokenPortable);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $notification
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
