<?php
namespace App\Adapter\Api\Rest;

use App\Core\Application\UseCase\AddBailUseCase;

class BailController
{
    private AddBailUseCase $addBailUseCase;

    public function __construct(AddBailUseCase $addBailUseCase)
    {
        $this->addBailUseCase = $addBailUseCase;
    }

    public function create(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $bailId = $this->addBailUseCase->execute($data);
            http_response_code(201);
            echo json_encode(['success' => true, 'bail_id' => $bailId]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
