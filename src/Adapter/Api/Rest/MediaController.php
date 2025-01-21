<?php

namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\UploadMediaUseCase;

class MediaController
{
    private UploadMediaUseCase $uploadMediaUseCase;

    public function __construct(UploadMediaUseCase $uploadMediaUseCase)
    {
        $this->uploadMediaUseCase = $uploadMediaUseCase;
    }

    public function upload(): void
    {
        try {
            if (!isset($_FILES['file'])) {
                throw new \Exception("Aucun fichier n'a été fourni.");
            }

            $this->uploadMediaUseCase->execute($_FILES['file'], $_POST);
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
