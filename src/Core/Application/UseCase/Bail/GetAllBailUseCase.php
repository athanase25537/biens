<?php

namespace App\Core\Application\UseCase\Bail;

use App\Core\Domain\Entity\Bail;
use App\Port\In\Bail\GetAllBailInputPort;
use App\Port\Out\BailRepositoryInterface;

class GetAllBailUseCase implements GetAllBailInputPort
{

    private $bailRepository;

    public function __construct(BailRepositoryInterface $bailRepository)
    {
        $this->bailRepository = $bailRepository;
    }

    public function execute(int $offset): ?array
    {
        return $this->bailRepository->getAllBail($offset);
    }
}