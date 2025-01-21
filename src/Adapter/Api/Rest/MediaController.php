<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\AddMediaUseCase;

class MediaController
{
    private $addMediaUseCase;

    public function __construct(AddMediaUseCase $addMediaUseCase)
    {
        $this->addMediaUseCase = $addMediaUseCase;
    }

    public function upload()
    {
        if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid file upload']);
            return;
        }

        $file = $_FILES['file'];
        $file = $_FILES['file'];
        $uploadDir = realpath(__DIR__ . '/../../../uploads');
        if (!$uploadDir) {
            mkdir(__DIR__ . '/../../../uploads', 0775, true);
            $uploadDir = realpath(__DIR__ . '/../../../uploads');
        }

        $filePath = $uploadDir . '/' . basename($file['name']);

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to save file']);
            return;
        }

        $mediaData = [
            'bien_id' => $_POST['bien_id'] ?? null,
            'etat_lieux_items_id' => $_POST['etat_lieux_items_id'] ?? null,
            'incidents_id' => $_POST['incidents_id'] ?? null,
            'type' => $_POST['type'] ?? 'image',
            'url' => $filePath,
            'description' => $_POST['description'] ?? '',
            'position' => $_POST['position'] ?? null,
        ];
        // $createdMedia = $this->addMediaUseCase->execute($mediaData);
        if ($this->addMediaUseCase->execute($mediaData)) {
            http_response_code(200);

                        header('Content-Type: application/json');
                        echo json_encode([
                            'success' => true,
                            'data' => [
                                // 'id' => $createdMedia->getId(),
                                'message' => 'Media ajouté avec succès'
                            ]
                        ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to save media data']);
        }
    }
}
