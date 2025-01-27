<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Notification;
use App\Port\Out\NotificationRepositoryInterface;

class SendNotificationUseCase
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function execute(int $userId, string $type, string $contenu, string $tokenPortable): Notification
    {
        $notification = new Notification();
        $notification->setUserId($userId);
        $notification->setTypeNotification($type);
        $notification->setContenu($contenu);
        $notification->setStatut('pending');
        $notification->setTokenPortable($tokenPortable);

        return $this->notificationRepository->save($notification);
    }
}
