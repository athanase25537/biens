<?php

namespace App\Adapter\Persistence\Doctrine;

use App\Core\Domain\Entity\Media;
use App\Port\Out\MediaRepositoryInterface;
use App\Port\Out\DatabaseAdapterInterface;

class MediaRepository implements MediaRepositoryInterface
{
    private $db;

    public function __construct(DatabaseAdapterInterface $db)
    {
        $this->db = $db;
    }

    public function saveMedia(Media $media): Media
    {
        $this->db->execute(
            "INSERT INTO medias 
            (bien_id, etat_lieux_items_id, incidents_id, type, url, description, position, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $media->getBienId(),
                $media->getEtatLieuxItemsId(),
                $media->getIncidentsId(),
                $media->getType(),
                $media->getUrl(),
                $media->getDescription(),
                $media->getPosition()
            ]
        );

        return $media;
    }

    public function findMediaById(int $id): ?Media
    {
        $row = $this->db->findOne(
            "SELECT * FROM medias WHERE id = ?",
            [$id]
        );

        return $row ? $this->mapToEntity($row) : null;
    }

    public function deleteMedia(int $id): void
    {
        $this->db->execute(
            "DELETE FROM medias WHERE id = ?",
            [$id]
        );
    }

    private function mapToEntity(array $row): Media
    {
        $media = new Media();
        $media->setId($row['id']);
        $media->setBienId($row['bien_id']);
        $media->setEtatLieuxItemsId($row['etat_lieux_items_id']);
        $media->setIncidentsId($row['incidents_id']);
        $media->setType($row['type']);
        $media->setUrl($row['url']);
        $media->setDescription($row['description']);
        $media->setPosition($row['position']);
        $media->setCreatedAt(new \DateTime($row['created_at']));
        $media->setUpdatedAt(new \DateTime($row['updated_at']));

        return $media;
    }
}
