<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Notification;
use App\Port\Out\NotificationRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $dbAdapter)
    {
        $this->db = $dbAdapter;
    }

    public function save(Notification $notification): Notification
    {
        $query = "INSERT INTO notifications (user_id, type_notification, contenu, statut, token_portable, date_creation)
                  VALUES (?, ?, ?, ?, ?, NOW())";
        $this->db->execute($query, [
            $notification->getUserId(),
            $notification->getTypeNotification(),
            $notification->getContenu(),
            $notification->getStatut(),
            $notification->getTokenPortable()
        ]);

        $notification->setId((int)$this->db->lastInsertId());
        return $notification;
    }

    public function findById(int $id): ?Notification
    {
        $row = $this->db->findOne("SELECT * FROM notifications WHERE id = ?", [$id]);
        return $row ? $this->mapToEntity($row) : null;
    }

    public function findByUserId(int $userId): array
    {
        $rows = $this->db->findAll("SELECT * FROM notifications WHERE user_id = ?", [$userId]);
        return array_map([$this, 'mapToEntity'], $rows);
    }

    public function updateStatut(int $id, string $statut): bool
    {
        return $this->db->execute(
            "UPDATE notifications SET statut = ? WHERE id = ?",
            [$statut, $id]
        );
    }

    private function mapToEntity(array $row): Notification
    {
        $notification = new Notification();
        $notification->setId($row['id']);
        $notification->setUserId($row['user_id']);
        $notification->setTypeNotification($row['type_notification']);
        $notification->setContenu($row['contenu']);
        $notification->setStatut($row['statut']);
        $notification->setTokenPortable($row['token_portable']);
        $notification->setDateCreation(new \DateTime($row['date_creation']));
        $notification->setDateEnvoi($row['date_envoi'] ? new \DateTime($row['date_envoi']) : null);

        return $notification;
    }
}
