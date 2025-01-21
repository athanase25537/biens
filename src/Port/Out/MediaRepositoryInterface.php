<?php

namespace App\Port\Out;

use App\Core\Domain\Entity\Media;

interface MediaRepositoryInterface
{
    public function saveMedia(Media $media): Media;
    public function findMediaById(int $id): ?Media;
    public function deleteMedia(int $id): void;
}
