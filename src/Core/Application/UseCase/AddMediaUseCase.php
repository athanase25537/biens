<?php

namespace App\Core\Application\UseCase;

use App\Core\Domain\Entity\Media;
use App\Port\Out\MediaRepositoryInterface;

class AddMediaUseCase
{
    private $mediaRepository;

    public function __construct(MediaRepositoryInterface $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function execute(array $mediaData): Media
    {
      	$uniqueId = $this->generateUniqueId();
        $media = new Media();
        $media->setBienId($mediaData['bien_id'] ?? null);
        $media->setEtatLieuxItemsId($mediaData['etat_lieux_items_id'] ?? null);
        $media->setIncidentsId($mediaData['incidents_id'] ?? null);
        $media->setType($mediaData['type']);
        $media->setUrl($mediaData['url']);
        $media->setDescription($mediaData['description']);
        $media->setPosition($mediaData['position'] ?? null);
        $media->setCreatedAt(new \DateTime());
        $media->setUpdatedAt(new \DateTime());
      
      	$media->setName($uniqueId . '-' . basename($mediaData['url']));


        return $this->mediaRepository->saveMedia($media);
    }
      private function generateUniqueId(): string
    {
        return str_pad(rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
    }
}
