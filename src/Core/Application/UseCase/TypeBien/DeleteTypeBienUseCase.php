<?php

namespace App\Core\Application\UseCase\TypeBien;

use App\Core\Domain\Entity\TypeBien;
use App\Port\In\TypeBien\DeleteTypeBienInputPort;
use App\Port\Out\TypeBienRepositoryInterface;

class DeleteTypeBienUseCase implements DeleteTypeBienInputPort
{

    private $typeBienRepository;

    public function __construct(TypeBienRepositoryInterface $typeBienRepository)
    {
        $this->typeBienRepository = $typeBienRepository;
    }

    public function execute(int $typeBienId): void
    {
        $delete = $this->typeBienRepository->destroy($typeBienId);
    }
}