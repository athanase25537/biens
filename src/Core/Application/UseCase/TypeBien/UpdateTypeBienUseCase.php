<?php

namespace App\Core\Application\UseCase\TypeBien;

use App\Core\Domain\Entity\TypeBien;
use App\Port\In\TypeBien\UpdateTypeBienInputPort;
use App\Port\Out\TypeBienRepositoryInterface;

class UpdateTypeBienUseCase implements UpdateTypeBienInputPort
{

    private $typeBienRepository;

    public function __construct(TypeBienRepositoryInterface $typeBienRepository)
    {
        $this->typeBienRepository = $typeBienRepository;
    }

    public function execute(int $typeBienId, array $data): ?array
    {
        $update = $this->typeBienRepository->update($typeBienId, $data);
        return ($update) ? $this->typeBienRepository->getTypeBien($typeBienId) : null;
    }
}