<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Media;
use App\Port\Out\MediaRepositoryInterface;

class UploadMediaUseCase
{
    private MediaRepositoryInterface $mediaRepository;

    public function __construct(MediaRepositoryInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function execute(array $file, array $data): void
    {

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Erreur lors de l'upload du fichier.");
        }


        $uploadDir = __DIR__ . '/../../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filePath = $uploadDir . basename($file['name']);
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new \Exception("Impossible de déplacer le fichier uploadé.");
        }


        $media = new Media();
        $media->setBienId($data['bien_id']);
        $media->setType($data['type']);
        $media->setUrl('/uploads/' . basename($file['name']));
        $media->setDescription($data['description'] ?? null);
        $media->setPosition($data['position'] ?? null);
        $media->setCreatedAt(new \DateTimeImmutable());
        $media->setUpdatedAt(new \DateTimeImmutable());

        $this->mediaRepository->create($media);
    }
}
