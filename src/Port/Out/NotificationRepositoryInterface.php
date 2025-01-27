<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\Notification;

interface NotificationRepositoryInterface
{
    public function save(Notification $notification): Notification;

    public function findById(int $id): ?Notification;

    public function findByUserId(int $userId): array;

    public function updateStatut(int $id, string $statut): bool;
}
